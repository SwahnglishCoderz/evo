<?php

namespace Evo\Base;

use Evo\Base\BaseEntity;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Orm\ClientRepository\ClientRepository;
use Evo\Orm\ClientRepository\ClientRepositoryFactory;
use Throwable;

class BaseModel
{
    protected string $tableSchema;
    protected string $tableSchemaID;
    protected Object $repository;
    protected BaseEntity $entity;

    /**
     * @throws Throwable
     */
    public function __construct(string $tableSchema = null, string $tableSchemaID = null, string $entity = null)
    {
        $this->throwExceptionIfNotExisting($tableSchema, $tableSchemaID);
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
//        $this->casting(self::ALLOWED_CASTING_TYPES);
        $this->createRepository($this->tableSchema, $this->tableSchemaID);

//        parent::__construct($this);
    }

    /**
     * Create the model repositories
     */
    public function createRepository(string $tableSchema, string $tableSchemaID): void
    {
        try {
//            $factory = new DataRepositoryFactory('baseModel', $tableSchema, $tableSchemaID);
            $factory = new ClientRepositoryFactory('baseModel', $tableSchema, $tableSchemaID);
//            $this->repository = $factory->create(DataRepository::class);
            $this->repository = $factory->create(ClientRepository::class);

        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * Throw an exception if the two required model constants is empty
     */
    private function throwExceptionIfNotExisting(string $tableSchema, string $tableSchemaID): void
    {
        if (empty($tableSchema) || empty($tableSchemaID)) {
            throw new BaseInvalidArgumentException('Your repository is missing the required constants. Please add the TABLESCHEMA and TABLESCHEMAID constants to your repository.');
        }
    }

    public function getCurrentRepository(): object
    {
        return $this->repository;
    }

    public function getSchemaID(): string
    {
        return $this->tableSchemaID;
    }

    public function getSchema(): string
    {
        return $this->tableSchema;
    }

    public function getEntity(): BaseEntity
    {
        return $this->entity;
    }
}