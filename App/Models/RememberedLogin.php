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

use Evo\Model;
use Exception;
use PDO;
use \App\Token;

class RememberedLogin extends Model
{
    /**
     * Find a remembered login model by the token
     * @throws Exception
     */
    public static function findByToken(string $remembered_login_token)
    {
        $remembered_login_token = new Token($remembered_login_token);
        $token_hash = $remembered_login_token->getHash();

        $sql = 'SELECT * FROM remembered_logins
                WHERE token_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Get the user model associated with this remembered login
     */
    public function getUser(): UserModel
    {
        return (new UserModel)->getNameForSelectField($_SESSION['user_id']);
    }

    /**
     * See if the remember_token has expired or not, based on the current system time
     */
    public function hasExpired(): bool
    {
        return strtotime($this->expires_at) < time();
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
}
