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

use Evo\DataSchema\Traits\DataSchemaTrait;
use Evo\DataSchema\Exception\DataSchemaUnexpectedValueException;

class DataSchema extends AbstractDataSchema
{
    use DataSchemaTrait;

    protected array $schemaObject = [];
    protected string $element = '';
    protected string $primaryKey;
    protected $uniqueKey = null;
    protected $ukey = null;

    protected string $tableSchema = '';
    
    protected const MODIFY = 'modify';
    protected const ADD = 'add';
    protected const CHANGE = 'change';
    protected const DROP = 'drop';
    private object $dataModel;

    public function __construct()
    {
        parent::__construct();
    }

    public function schema(array $overridingSchema = []): DataSchema
    {
        if ($overridingSchema) {
            $attr = array_merge(self::DEFAULT_SCHEMA, $overridingSchema);
        } else {
            $attr = self::DEFAULT_SCHEMA;
        }
        if (is_array($attr)) {
            foreach ($attr as $key => $value) {
                if (!$this->validateSchema($key, $value)) {
                    $this->validateSchema($key, self::DEFAULT_SCHEMA[$key]);
                }
            }
        }
        return $this;
    }

    public function table(object $dataModel): DataSchema
    {
        $this->dataModel = $dataModel;
        return $this;
    }

    public function row($args = null)
    {
        if (is_array($args)) {
            $args = $args; // WTH
            foreach ($args as $schemaObjectType => $schemaObjectOptions) {
                $newSchemaObject = new $schemaObjectType($schemaObjectOptions);
                if (!$newSchemaObject instanceof DataSchemaTypeInterface) {
                    throw new DataSchemaUnexpectedValueException('Invalid dataSchema type supplied. It does not implement the DataSchemaTypeInterface.');
                }
                $this->schemaObject[] = $newSchemaObject;
                return $this;
            }
        }
    }

    public function build(callable $callback = null): string
    {
        $bt4 = "\t\t\t\t";
        $bt3 = "\t\t\t";
        $eol = PHP_EOL;

        if (is_array($this->schemaObject) && count($this->schemaObject) > 0) {
            $this->element .= "{$bt3}CREATE TABLE IF NOT EXISTS `{$_ENV['DB_NAME']}`.`{$this->dataModel->getSchema()}`" . $eol;
            $this->element .= "{$bt3}(" . $eol;
            foreach ($this->schemaObject as $schema) {
                $this->element .= $bt4 . $schema->render() . $eol;
            }
            if (is_callable($callback)) {
                $this->element .= $bt4 . call_user_func_array($callback, [$this]) . $eol;
            }
            $this->element .= $bt3 . ')' . $eol;
            $this->element .= $bt3 . $this->getSchemaAttr() . $eol;
            $this->element .= $eol;
        }
        return $this->element;
    }

    public function drop(): string
    {
        return "DROP TABLE " . $this->dataModel->getSchema();
    }

    /**
     * The alter statement is used to add, drop or modify an existing database
     * table. It can also be used drop and add constraints on an existing
     * table as well
     */
    public function alter(string $type, Callable $callback): string
    {
        if (!is_callable($callback)) {
            /* do something */
        }
        if (!in_array($type, ['add', 'drop', 'modify'])) {
            /* throw exception */
        }
        $element = "\t\t\t" . 'ALTER TABLE ' . "`{$this->dataModel->getSchema()}`" . PHP_EOL;
        switch ($type) {
            case 'modify' :
                $element .= "\t\tMODIFY COLUMN " . $callback($this);
                $element = substr_replace($element, '', -3);
                break;
            case 'change' :
                $element .= "\t\tCHANGE COLUMN " . $callback($this);
                $element = substr_replace($element, '', -3);
                break;    
            case 'add' :
                $element .= "\t\t\tADD COLUMN" . $callback($this);
                $element = substr_replace($element, '', -3);
                break;
            case 'drop' :
                $element .= "\t\t\tDROP COLUMN " . $callback($this);
                break;
        }
        $element .= ';';
        $element .= PHP_EOL;
        return $element;
    }

    /**
     * Add a column to an existing database table
     */
    public function addColumn(): string
    {
        foreach ($this->schemaObject as $schema) {
            return $schema->render() . PHP_EOL;
        }

    }

    /**
     * Drop a column from an existing database table
     */
    public function dropColumn(string $columnName): string
    {
        return $columnName;
    }

    /**
     * Modify an existing column datatype or column constraints
     */
    public function modifyColumn(): string
    {
        return $this->addColumn();
    }

    /**
     * Change the name of an existing database table column We can also change
     * the datatype and constraints
     */
    public function changeColumn(string $oldColumnName): string
    {
        return "`{$oldColumnName}`" . ' ' . $this->addColumn();
    }

    /**
     * Drop the specified table from the database
     */
    public function destroy(): string
    {
        return "\t\tDROP TABLE " . $this->dataModel->getSchema() . PHP_EOL;
    }
}
