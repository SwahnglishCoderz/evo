<?php

namespace Evo\Auth;

use App\Models\UserModel;
use Evo\Base\AbstractBaseModel;
use Evo\Base\BaseModel;
use Evo\Utility\Token;
use Exception;
use PDO;
use Throwable;

//class RememberedLogin extends BaseModel
class RememberedLogin extends AbstractBaseModel implements RememberedLoginInterface
{
    protected const TABLESCHEMA = 'remembered_login';
    protected const TABLESCHEMAID = 'id';

    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID);
    }

    public function guardedID(): array
    {
        return [];
    }

    public function getSchemaID(): string
    {
        return self::TABLESCHEMAID;
    }

    public function getSchema(): string
    {
        return self::TABLESCHEMA;
    }

    /**
     * Find a remembered login model by the token
     * @throws Exception|Throwable
     */
    public function findByToken(string $remembered_login_token): Object // OG
    {
        try {
            $remembered_login_token = new Token($remembered_login_token);
            $token_hash = $remembered_login_token->getHashedTokenValue();

            $tokenUser = $this->getRepository()->findObjectBy(['token_hash' => $token_hash], []);
            if ($tokenUser !=null) {
                return $tokenUser;
            }
        } catch(Throwable $th) {
            throw $th;
        }
    }

//    public function findByToken(string $token) : Object // MAGMA
//    {
//        try {
//            $token = new \Evo\Utility\Token($token);
//            $tokenHash = $token->getHash();
//            $tokenUser = $this->getRepository()->findObjectBy(['token_hash' => $tokenHash], []);
//            if ($tokenUser !=null) {
//                return $tokenUser;
//            }
//        }catch(Throwable $th) {
//            throw $th;
//        }
//    }

    /**
     * See if the remember_token has expired or not, based on the current system time
     */
    public function hasExpired(): bool // OG
    {
        return strtotime($this->expires_at) < time();
    }

//    public function hasExpired(string $expires) : bool // MAGMA
//    {
//        if (!empty($expires)) {
//            return strtotime($expires) < time();
//        }
//    }

    public function destroy(string $tokenHash) : bool
    {
        try {
            $destroy = $this
                ->getRepository()
                ->getEm() /* Access entity manager object */
                ->getCrud()
                ->delete(['token_hash' => $tokenHash]);
            if ($destroy) {
                return $destroy;
            }
            return false;
        } catch(Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete this model
     */
    public function delete()
    {
        $sql = 'DELETE FROM remembered_logins
                WHERE token_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * Get the user model associated with this remembered login
     */
    public function getUser(): UserModel // OG
    {
        return (new UserModel)->getNameForSelectField($_SESSION['user_id']);
    }

//    public function getUser(int $userID) : Object // MAGMA
//    {
//        if (!empty($userID)) {
//            return $this->getRepository()->findObjectBy([], ['id' => $userID]);
//        }
//    }

    /**
     * @throws Exception
     */
    public function rememberedLogin(int $userID) : array
    {
        $token = new Token();
        $tokenHash = $token->getHashedTokenValue();
        $tokenValue = $token->getTokenValue();
        $timestampExpiry = time() + 60 * 60 * 24 * 30; // 30 days from now

        $fields = [
            'token_hash' => $tokenHash,
            'expires_at' => date('Y-m-d H:i:s', $timestampExpiry),
            'id' => $userID
        ];

        $persisted = $this
            ->getRepository()
            ->getEm()
            ->getCrud()
            ->create($fields);
        if ($persisted) {
            return [
                $tokenValue,
                $timestampExpiry
            ];
        }
    }


}