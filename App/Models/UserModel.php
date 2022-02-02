<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace App\Models;

use App\Entity\UserEntity;
use Evo\Base\AbstractBaseModel;
use Evo\System\Config;
use Evo\System\Status;
use Evo\Utility\ClientIP;
use Evo\Utility\Token;
use Exception;
use PDO;
use Evo\Mail\Mail;
use Evo\Base\BaseView;
use Throwable;

class UserModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'user';
    protected const TABLESCHEMAID = 'id';

    public array $errors = [];

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws Throwable
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, UserEntity::class);

    }

    /**
     * Guard these IDs from being deleted etc...
     */
    public function guardedID(): array
    {
        return ['id'];
    }

    public function getNameForSelectField($id, $field_names = [])
    {
        return $this->getRepository()->findObjectBy(['id' => $id], $field_names);
    }

    /**
     * @throws Exception
     */
    private function token(string $token = null): Token
    {
        return new Token($token);
    }

    /**
     * Save the user model with the current property values
     * @throws Exception
     */
    public function save(array $data = []): bool
    {
        $remote_address = ClientIP::getClientIp();

        foreach ($data as $key => $value) {
            $this->$key = $value;
        };

        $this->remote_addr = $remote_address;

        $this->validate();

        if (empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $hashed_token = $this->token()->getHashedTokenValue();
            $this->activation_token = $this->token()->getTokenValue();

            return $this->repository->getEm()->getCrud()->create(
                [
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'email' => $this->email,
                    'password_hash' => $password_hash,
                    'activation_hash' => $hashed_token,
                    'remote_addr' => $this->remote_addr,
                ]
            );
        }

        return false;
    }

    /**
     * Validate current property values, adding validation error messages to the errors array property
     */
    public function validate()
    {

        if ($this->firstname == '' || $this->lastname == '') {
            $this->errors[] = 'Both names are required';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        if (self::doesEmailExist($this->email, $this->id ?? null)) {
            $this->errors[] = 'Email already taken';
        }

        // Password
        if (isset($this->password) && isset($this->confirm_password)) {

            if (strlen($this->password) < 6) {
                $this->errors[] = 'Please enter at least 6 characters for the password';
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one letter';
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one number';
            }

            if ($this->password !== $this->confirm_password) {
                $this->errors[] = 'The passwords must match';
            }

        }
    }

    public static function doesEmailExist(string $email, string $ignore_id = null): bool
    {
        $user = static::findByEmail($email);
        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }
        return false;
    }

    public static function findByEmail(string $email)
    {
        return (new UserModel())->getRepository()->findObjectBy(['email' => $email]);
    }

    /**
     * Authenticate a user by email and password. User account has to be active.
     */
    public static function authenticate(string $email, string $password)
    {
        $user = static::findByEmail($email);

        if ($user && ($user->status_id == Status::ACTIVE)) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     * @throws Exception
     */
    public function rememberLogin(): bool
    {
        $token = new Token();
        $hashed_token = $token->getHashedTokenValue();
        $this->remember_token = $token->getTokenValue();

        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions to the user specified
     */
    public static function sendPasswordReset(string $email)
    {
        $user = static::findByEmail($email);

        if ($user) {

            if ($user->startPasswordReset()) {
                $user->sendPasswordResetEmail();
            }
        }
    }

    /**
     * Start the password reset process by generating a new token and expiry
     * @throws Exception
     */
    protected function startPasswordReset(): bool
    {
        $token = new Token();
        $hashed_token = $token->getHashedTokenValue();
        $this->password_reset_token = $token->getTokenValue();

        $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

        $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions in an email to the user
     * @throws Exception
     */
    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = BaseView::getTemplate('password/reset_email.txt', ['url' => $url]);
        $html = BaseView::getTemplate('password/reset_email.html', ['url' => $url]);

        Mail::sendMessage($this->email, 'Password Reset', $text, $html);
    }

    /**
     * Find a user model by password reset token and expiry
     * @throws Exception
     */
    public static function findByPasswordReset(string $password_reset_token)
    {
        $password_reset_token = new Token($password_reset_token);
        $hashed_token = $password_reset_token->getHashedTokenValue();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {

            // Check password reset token hasn't expired
            if (strtotime($user->password_reset_expires_at) > time()) {

                return $user;
            }
        }
    }

    /**
     * Reset the password
     */
    public function resetPassword(string $password): bool
    {
        $this->password = $password;

        $this->validate();

        //return empty($this->errors);
        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password_hash = :password_hash,
                        password_reset_hash = NULL,
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Email the user containing the activation link
     * @throws Exception
     */
    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;

        $text = BaseView::getTemplate('signup/activation_email.txt', ['url' => $url]);
        $html = BaseView::getTemplate('signup/activation_email.html', ['url' => $url]);

        Mail::sendMessage($this->email, 'Account activation', $text, $html);
    }

    /**
     * Activate the user account with the specified activation token
     * @throws Exception
     */
    public static function activateAccount(string $activation_token): bool
    {
        $token = new Token($activation_token);
        $hashed_token = $token->getHashedTokenValue();
        $findByToken = (new UserModel())->getRepository()->findObjectBy(['activation_hash' => $hashed_token]);

        return (new UserModel())
            ->getRepository()
            ->findByIdAndUpdate(
                ['activation_hash' => null, 'status_id' => Status::ACTIVE],
                $findByToken->id
            );
    }

    public function updateProfile(array $data, $id): bool
    {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];

        // Only validate and update the password if a value provided
        if ($data['password_hash'] != '') {
            $this->password = $data['password_hash'];
        }

        $this->validate();

        $data_changed = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
        ];

        if ($data['password_hash'] != '') {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $data_changed['password_hash'] = $password_hash;
        } else {
            unset($data['password_hash']);
        }

        return $this->repository->findByIdAndUpdate($data_changed, intval($id));
    }
}