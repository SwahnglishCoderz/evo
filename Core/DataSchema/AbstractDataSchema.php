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

use Evo\DataSchema\Exception\DataSchemaInvalidArgumentException;

abstract class AbstractDataSchema implements DataSchemaInterface
{

    /** @var array - database schema settings */
    protected const DEFAULT_SCHEMA = [
        'collate' => 'utf8mb4_unicode_ci',
        'engine' => 'innoDB',
        'charset' => 'utf8mb4',
        'row_format' => 'dynamic'
    ];
    private array $schemaAttr;

    /**
     * Main constructor method
     */
    public function __construct()
    {
    }   

    /**
     * Throw an exception of the key is empty
     */
    protected function isEmptyThrowException($key): bool
    {
        if (empty($key)) {
            throw new DataSchemaInvalidArgumentException('Invalid or empty schema. Ensure the schema is not empty and is valid.');
        }
    }

    /**
     * Validate the schema
     */
    protected function validateSchema(string $key, $value) : bool
    {
        $this->isEmptyThrowException($key);
        switch ($key) {
            case 'collate' :
                if (!in_array($value, ['utf8mb4_unicode_ci'])) {
                    throw new DataSchemaInvalidArgumentException('Invalid collate within schema');
                }
                break;
            case 'engine' :
                if (!in_array($value, ['innoDB', 'MyISAM', 'XtraDB', 'Falcon', 'TokuDB', 'Aria'])) {
                    throw new DataSchemaInvalidArgumentException('Invalid engine within schema');
                }
                break;
            case 'charset' :
                if (!in_array($value, ['utf8mb4'])) {
                    throw new DataSchemaInvalidArgumentException('Invalid charset within schema');
                }
                break;
            case 'row_format' :
                if (!in_array($value, ['dynamic', 'compact', 'redundant', 'compressed'])) {
                    throw new DataSchemaInvalidArgumentException('Invalid row format within schema');
                }
                break;
        }
        $this->schemaAttr[$key] = $value;
        return true;
    }

    /**
     * Return the database engine schema
     */
    public function getSchemaAttr(): string
    {
        return "ENGINE={$this->schemaAttr['engine']} DEFAULT CHARSET={$this->schemaAttr['charset']} COLLATE={$this->schemaAttr['collate']} ROW_FORMAT=" . strtoupper($this->schemaAttr['row_format']);
    }


}