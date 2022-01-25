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

namespace Evo\Base\Domain\Actions;

use Evo\Base\Domain\DomainActionLogicInterface;
use Evo\Base\Domain\DomainTraits;
use Evo\Utility\Yaml;

/**
 * Class which handles the domain logic when adding a new item to the database
 * items are sanitized and validated before persisting to database. The class will
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class LogIndexAction implements DomainActionLogicInterface
{

    use DomainTraits;

    private object $controller;
    private string $method;
    private ?string $schema;

    /**
     * execute logic for adding new items to the database()
     */
    public function execute(
        object $controller,
        ?string $entityObject,
        ?string $eventDispatcher,
        ?string $objectSchema,
        string $method,
        array $rules = [],
        array $additionalContext = [],
        $optional = null
    ): self {

        $this->controller = $controller;
        $this->method = $method;
        $this->schema = $objectSchema;

        $this->args = $this->getControllerArgs($controller);
        $this->tableRepository = $controller->repository->getRepo()->findWithSearchAndPaging($controller->request->handler(), $this->args);
        $this->tableData = $controller->tableGrid;

        if ($this->tableData)
            return $this;
    }

}

