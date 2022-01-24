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

interface UserActivationInterface
{ 

    /**
     * Find and return a user object via the token provided
     */
    public function findByActivationToken(string $token) : ?Object;

    /**
     * Send an activation email when the user registration event is fired
     */
    public function sendUserActivationEmail(string $hash) : self;

    /**
     * Validate the user object. Ensuring the user object doesn't returned null.
     */
    public function validateActivation(?object $repository) : self;

    /**
     * Activate the user account
     */
    public function activate() : bool;

}