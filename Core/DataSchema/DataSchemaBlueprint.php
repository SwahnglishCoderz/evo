<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Evo\DataSchema;

//use JetBrains\PhpStorm\ArrayShape;
use Evo\DataSchema\Types\JsonType;
use Evo\DataSchema\Types\StringType;
use Evo\DataSchema\Types\NumericType;
use Evo\DataSchema\Types\DatetimeType;

class DataSchemaBlueprint implements DataSchemaBlueprintInterface
{

    protected string $primaryKey;
    protected array $attributes = array();

    /**
     * Set the table primary key
     */
    private function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Automatically generated the auto increment id column for each table
     * if no default name is set this method will assume your primary key
     * field will be called generic `id`.
     */
    public function autoID(string $name = 'id', int $length = 10): array
    {
        $this->setPrimaryKey($name);
        return $this->int($name, $length, false, 'unsigned', 'none', true);
    }

    /**
     * Return the auto generated primary key field which allows us to use 
     * else where within the class
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * create a varchar based row. with option length/value assignment
     */
    public function varchar(string $name, int $length = 196, bool $null = false, $default = null): array
    {
        //$this->varchar[] = $name;
        return [
            StringType::class => ['name' => $name, 'type' => 'varchar', 'length' => $length, 'null' => $null, 'default' => $default],
        ];
    }

    /**
     * create a text based row.
     */
    public function text(string $name, bool $null = false, $default = null): array
    {
        return [
            StringType::class => ['name' => $name, 'type' => 'text', 'null' => $null, 'default' => $default],
        ];
    }

    /**
     * create a longtext based row.
     */
    public function longText(string $name, bool $null = false, $default = null): array
    {
        return [
            StringType::class => ['name' => $name, 'type' => 'longtext', 'null' => $null, 'default' => $default],
        ];
    }

    /**
     * create a tinytext based row.
     */
    public function tinyText(string $name, bool $null = false, $default = null): array
    {
        return [
            StringType::class => ['name' => $name, 'type' => 'tinytext', 'null' => $null, 'default' => $default],
        ];
    }

    /**
     * Return the json field type
     */
    public function json(string $name): array
    {
        return [
            JsonType::class => ['name' => $name, 'type' => 'json']
        ];
    }

    /**
     * create an integer based row. Length field is set to null, so this is a required
     * argument which must be set within the class which is using this method
     */
    public function int(string $name, int $length = null, bool $null = true, string $attributes = 'unsigned', $default = null, bool $autoIncrement = false): array
    {
        return [
            NumericType::class => ['name' => $name, 'type' => 'int', 'length' => $length, 'null' => $null, 'default' => $default, 'attributes' => $attributes, 'auto_increment' => $autoIncrement],
        ];

    }

    /**
     * Undocumented function
     */
    public function datetime(string $name, bool $null = false, string $default = 'ct', string $attributes = ''): array
    {
        return [
            DatetimeType::class => ['type' => 'datetime', 'name' => $name, 'null' => $null, 'default' => $default, 'attributes' => $attributes]        
        ];

    }

    /**
     * Undocumented function
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

}
