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
use Evo\Model;
use Evo\Status;
use Exception;
use PDO;
use \App\Token;
use \App\Mail;
use Evo\View;
use Throwable;

class UserModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'users';
    protected const TABLESCHEMAID = 'id';

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
        return [];
    }

    public function getNameForSelectField($id, $field_names = [])
    {
        return $this->getCurrentRepository()->findObjectBy(['id' => $id], $field_names);
    }

    /**
     * Validate current property values, adding validation error messages to the errors array property
     */
    public function validate()
    {
        // Name
        if ($this->name == '') {
            $this->errors[] = 'Name is required';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }
        if (static::doesEmailExist($this->email, $this->id ?? null)) {
            $this->errors[] = 'email already taken';
        }

        // Password
        if (isset($this->password)) {

            if (strlen($this->password) < 6) {
                $this->errors[] = 'Please enter at least 6 characters for the password';
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one letter';
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one number';
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
        return (new UserModel)->getCurrentRepository()->findObjectBy(['email' => $email]);
    }

    public function updateProfile(array $data, $id): bool
    {
//        print_r(intval($id));
//        exit;
//        return $this->repository->getEm()->getCrud()->update([$_SESSION['id']], ['name', 'email']);
//        return $this->repository->save();
        return $this->repository->findByIdAndUpdate($data, intval($id));
    }
}