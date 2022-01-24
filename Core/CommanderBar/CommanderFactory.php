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

namespace Evo\CommanderBar;

use Exception;

class CommanderFactory
{

    /**
     * Create the command bar object and pass the required object arguments
     * @throws Exception
     */
    public function create(?object $controller = null)
    {
        return new CommanderBar($controller);
    }

}