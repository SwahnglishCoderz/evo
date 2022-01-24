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

interface ApplicationCommanderInterface
{

    /**
     * Returns different variant of the controller name whether that be capitalized
     * pluralize or just a normal justify lower case controller name
     */
    public function getName(object $controller, string $type = 'lower'): string;

    /**
     * Return the query column value from the relevant controller settings row
     * if available. Not all table will have a query column
     */
    public function getStatusColumn(object $controller): ?string;

    /**
     * Dynamically get the queried value based on the query parameter. Using the 
     * status column return from the controller settings table for the relevant 
     * controller.
     */
    public function getStatusColumnFromQueryParams(object $controller);

    /**
     * Return the build for the commander bar
     */
    public function getHeaderBuild(object $controller): string;

}