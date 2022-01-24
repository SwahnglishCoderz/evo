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

namespace Evo\Auth\Schema;

use Evo\Auth\Model\RememberedLoginModel;
use Evo\DataSchema\DataSchema;
use Evo\DataSchema\DataSchemaBlueprint;
use Evo\DataSchema\DataSchemaBuilderInterface;

class RememberedLoginSchema implements DataSchemaBuilderInterface
{

    /** @var object - $schema for chaining the schema together */
    protected object $schema;
    /** @var object - provides helper function for quickly adding schema types */
    protected object $blueprint;
    /** @var object - the database model this schema is linked to */
    protected object $rememberedLogin;

    /**
     * Main constructor class. Any typed hinted dependencies will be autowired. As this
     * class can be inserted inside a dependency container
     */
    public function __construct(DataSchema $schema, DataSchemaBlueprint $blueprint, RememberedLoginModel $rememberedLogin)
    {
        $this->schema = $schema;
        $this->blueprint = $blueprint;
        $this->rememberedLogin = $rememberedLogin;
    }

    public function createSchema(): string
    {
        return $this->schema
            ->schema()
            ->table($this->rememberedLogin)
            ->row($this->blueprint->autoID())
            ->row($this->blueprint->varchar('token_hash', 64))
            ->row($this->blueprint->datetime('expires_at', false, 'none'))
            ->build(function ($schema) {
                return $schema
                    ->addPrimaryKey($this->blueprint->getPrimaryKey())
                    ->setUniqueKey(['token_hash'])
                    ->addKeys();
            });
    }
}
