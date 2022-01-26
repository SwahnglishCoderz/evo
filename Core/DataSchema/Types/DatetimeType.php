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

namespace Evo\DataSchema\Types;

use Evo\DataSchema\DataSchemaBaseType;
use Evo\DataSchema\DataSchemaTypeInterface;

class DatetimeType extends DataSchemaBaseType implements DataSchemaTypeInterface
{

    /** datetime schema types */
    protected array $types = [
        'date',
        'datetime',
        'timestamp',
        'time', 
        'json'
    ];

    /**
     * Undocumented function
     */
    public function __construct(array $row = [])
    {
        parent::__construct($row, $this->types);
    }

    /**
     * Undocumented function
     */
    public function render(): string
    {
        return parent::render();
    }

}