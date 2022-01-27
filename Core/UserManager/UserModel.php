<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\UserManager;

use Evo\UserManager\Rbac\Role\RoleRelationship;
use Evo\UserManager\Rbac\Role\RoleModel;
use Evo\Auth\Contracts\UserSecurityInterface;
use Evo\Base\AbstractBaseModel;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Utility\PasswordEncoder;
use Evo\Utility\UtilityTrait;
use Throwable;

class UserModel extends AbstractBaseModel implements UserSecurityInterface
{

    use UtilityTrait;

    protected const TABLESCHEMA = 'users';
    protected const TABLESCHEMAID = 'id';
    protected array $cast = ['firstname' => 'array_json'];
    public const COLUMN_STATUS = ['status' => ['pending', 'active', 'trash', 'lock', '']];

    /** $fillable - an array of fields that should not be null */
    protected array $fillable = [
        'firstname',
        'lastname',
        'email',
        'status',
        'password_hash',
        'created_byid',
        'remote_addr',
    ];
    protected ?string $validatedHashPassword;
    protected ?object $tokenRepository;

    /** bulk action array properties */
    protected array $unsettableClone = ['id', 'created_at', 'activation_token', 'password_reset_hash'];
    protected array $cloneableKeys = ['firstname', 'lastname', 'email'];

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws BaseInvalidArgumentException|Throwable
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, UserEntity::class);
        
    }

    /**
     * Guard these IDs from being deleted etc..
     */
    public function guardedID(): array
    {
        return [];
    }

    /**
     * Return an array of column values if table supports the column field
     */
    public function getColumnStatus(): array
    {
        return self::COLUMN_STATUS;
    }

    /**
     * See if a user record already exists with the specified email
     */
    public function emailExists(string $email, int $ignoreID = null): bool
    {
        if (!empty($email)) {
            $result = $this->getRepository()->findObjectBy(['email' => $email], ['*']);
            if ($result) {
                if ($result->id != $ignoreID) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Return true if the user account is activated. i.e. status is set to active
     * returns false otherwise.
     */
    public function accountActive(string $email): bool
    {
        if (!empty($email)) {
//            $result = $this->getRepository()->findObjectBy(['email' => $email], ['status']); // OG
            $result = $this->getRepository()->findObjectBy(['email' => $email], ['is_active']);
//            echo '<pre>';
//            print_r($result);
            if ($result) {
//                if ($result->status === 'active') {
                if ($result->is_active === 1) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Validate the new user password. Using the validate user object
     * Once the password is validated it will then be hash using the
     * passing hash from our traits services
     */
    public function validatePassword(object $entityCollection, ?object $repository = null)
    {
        $validate = $this->get('Validate.UserValidate', 'Evo\UserManager\\')->validate($entityCollection, $repository);
        if (empty($validate->errors)) {
            $this->validatedHashPassword = password_hash(
                $entityCollection->all()['password_hash'], 
                constant($this->appSecurity('password_algo')['default']), 
                $this->appSecurity('hash_cost_factor')
            );
            $this->tokenRepository = $repository;

            return $this;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getNameForSelectField($id)
    {
        return $this->getOtherModel(RoleModel::class)->getNameForSelectField($id);
    }

    /**
     * @return object
     */
    public function role(): object
    {
        return $this->getRelationship(RoleRelationship::class);
    }

    /**
     * Return the user object based on the passed parameter
     *
     * @param integer $userID
     * @return ?object
     */
    public function getUser(int $userID): ?object
    {
        if (empty($userID) || $userID === 0) {
            throw new BaseInvalidArgumentException('Please add a valid user id');
        }

        $user = $this->getRepository()->findObjectBy(['id' => $userID]);
        if ($user) {
            return $user;
        }

        return null;
    }

}