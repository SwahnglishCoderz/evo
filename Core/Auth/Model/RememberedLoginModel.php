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

namespace Evo\Auth\Model;

use Evo\Auth\Contracts\RememberedLoginInterface;
use Evo\Base\AbstractBaseModel;
use Evo\Utility\Token;
use Throwable;

class RememberedLoginModel extends AbstractBaseModel implements RememberedLoginInterface
{
    protected const TABLESCHEMA = 'remembered_logins';
    protected const TABLESCHEMAID = 'id';

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws Throwable
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID);
    }

    /**
     * Guard these IDs from being deleted etc...
     */
    public function guardedID() : array
    {
        return [];
    }

    /**
     * Returns the database table schema name
     */
    public function getSchemaID(): string
    {
        return self::TABLESCHEMAID;
    }

    /**
     * Returns the database table schema primary key
     */
    public function getSchema(): string
    {
        return self::TABLESCHEMA;
    }

    /**
     * @throws Throwable
     */
    public function findByToken(string $token) : Object
    { 
        try {
            $token = new Token($token);
            $tokenHash = $token->getHash();
            $tokenUser = $this->getRepository()->findObjectBy(['token_hash' => $tokenHash], []);
            if ($tokenUser !=null) {
                return $tokenUser;
            }
        } catch(Throwable $th) {
            throw $th;
        }
    }

    public function hasExpired(string $expires) : bool
    { 
        if (!empty($expires)) {
            return strtotime($expires) < time();
        }
    }

    /**
     * @throws Throwable
     */
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

    public function getUser(int $userID) : Object
    { 
        if (!empty($userID)) {
            return $this->getRepository()->findObjectBy([], ['id' => $userID]);
        }
    }

    public function rememberedLogin(int $userID) : array
    { 
        $token = new Token();
        $tokenHash = $token->getHash();
        $tokenValue = $token->getValue();
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
