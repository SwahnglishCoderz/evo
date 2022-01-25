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
use Evo\Cache\CacheInterface;
use Evo\Cache\Storage\NativeCacheStorage;
use Evo\Base\Domain\DomainTraits;
use Evo\Cache\CacheFacade;
use Evo\Utility\Yaml;

/**
 * Class which handles the domain logic when adding a new item to the database
 * items are sanitized and validated before persisting to database. The class will
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class SystemAction implements DomainActionLogicInterface
{

    use DomainTraits;

    private object $controller;
    private string $method;
    private ?string $schema;

    /** not currently being used */
    private CacheInterface $cache;

    /** not currently being used */
    public function __construct(CacheFacade $cache)
    {
        $this->cache = $cache->create('data_repository');
    }

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
        $this->schema = $objectSchema ?? null;

        $started = microtime(true);

        $controller->getSession()->set('redirect_parameters', $_SERVER['QUERY_STRING']);
        $this->args = $this->getControllerArgs($controller);
        $controllerName = $controller->thisRouteController();
        if ($controller->cache()) {
            $this->tableRepository = $controller->cache()->set($controllerName .'_index_controller', $controller->repository->getRepo()->findWithSearchAndPaging($controller->request->handler(), $this->args));
            if ($controller->cache()->get($controllerName .'_index_controller') !==null) {
                $this->tableRepository = $controller->cache()->get($controllerName .'_index_controller');
            } else {
                $this->tableRepository = $controller->repository->getRepo()->findWithSearchAndPaging($controller->request->handler(), $this->args);
            }
        }
        $this->tableData = $controller->tableGrid;
        $end = microtime(true);
        //Calculate the difference in microseconds.
        $difference = $end - $started;

        //Format the time so that it only shows 10 decimal places.
        $this->queryTime = number_format($difference, 8);
        if ($this->tableData)
            return $this;
    }

}
