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

interface UserSecurityInterface
{ 

    /**
     * Return the user object by the supplied email address
     */
    public function emailExists(string $email, int $ignoreID = null);

    /**
     * Validate a user by their password
     */
    public function validatePassword(object $cleanData, ?object $repository = null);

}