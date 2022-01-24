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

interface UserPasswordRecoveryInterface
{ 

    /**
     * Find and return the user object via the supplied email
     */
    public function findByUser(string $email) : self;

    /**
     * Send a reset password when the required event is fired
     */
    public function sendUserResetPassword(object $controller) : bool;

    /**
     * Initiate the password reset within the database
     */
    public function resetPassword(int $userID) : ?array;

    /**
     * Find the user object by the password reset token sent to the user when 
     * requesting a new password
     */
    public function findByPasswordResetToken(string $tokenHash = null) : ?Object;
    public function reset() : bool;

}