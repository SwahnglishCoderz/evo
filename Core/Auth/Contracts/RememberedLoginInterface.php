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

namespace Evo\Auth\Contracts;

interface RememberedLoginInterface
{

    /**
     * Find a remembered login model by the token
     */
    public function findByToken(string $token) : Object;

    /**
     * See if the remembered token has expired or not, based on the current system time
     */
    public function hasExpired(string $expires) : bool;

    /**
     * Delete this model. Simple by calling the delete method from the crud class.
     * we've already set a global key parameter at the very top of this class so all
     * we will need is the bound parameter for that key which we can pass as an
     * argument to the delete method
     */
    public function destroy(string $tokenHash) : bool;

    /**
     * Get the user model associated with this remembered login
     */
    public function getUser(int $userID) : Object;

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     */
    public function rememberedLogin(int $userID) : array;


}
