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

use Evo\Collection\Collection;

interface UserProfileInterface
{

    /**
     * Verify the user password before making changes. Ensuring the correct user 
     * is making changes.
     */
    public function verifyPassword(Object $object, int $id, ?string $fieldName = null) : bool;

    /**
     * Update the user first and lastname from their profile accounts page. Users name
     * will be subject to the same validation as registering a new account meaning 
     * users can only use valid and allowed characters
     */
    public function updateProfileAfterValidation(Collection $entityCollection, Object $repository) : array;

    /**
     * delete the user profile account
     */
    public function deleteAccountOnceValidated(Collection $entityCollection, ?Object $repository) : array;

    /**
     * Return an array of user profile errors
     *
     * @return array
     */
    public function getProfileErrors(): array;

}