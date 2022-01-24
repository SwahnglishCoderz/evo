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

namespace Evo\Session\Flash;

interface FlashInterface
{

    /**
     * Method for adding a flash message to the session
     */
    public function add(string $message, ?string $type = null) : void;

    /**
     * Get all the flash messages from the session
     */
    public function get();

}