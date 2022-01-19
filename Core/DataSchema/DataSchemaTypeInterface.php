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

namespace Evo\DataSchema;

interface DataSchemaTypeInterface
{

    /**
     * Return an array of the available schema type for the given schema object
     */
    public function getSchemaTypes(): array;

    /**
     * Return an array of the available schema columns for the given schema object
     */
    public function getSchemaColumns(): array;

    /**
     * Return an array of the available schema rows for the given schema object
     */
    public function getRow(): array;

    /**
     * Render the schema rows as a large concat string
     */
    public function render(): string;

}