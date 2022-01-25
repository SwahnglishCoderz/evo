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

use App\Config;
use Evo\Base\Domain\DomainTraits;
use Evo\Base\Domain\DomainActionLogicInterface;

/**
 * Class which handles the domain logic when adding a new item to the database
 * items are sanitized and validated before persisting to database. The class will
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class ControllerSettingsAction implements DomainActionLogicInterface
{

    use DomainTraits;

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

        if (isset($controller->formBuilder)) :
            if ($controller->formBuilder->isFormValid($this->getSubmitValue())) { /* return true if form  is valid */
                $controller->formBuilder->validateCsrf($controller); /* Checks for csrf validation token */
                $formData = $controller->formBuilder->getData();
                $settingsController = Config::CONTROLLER[$this->thisRouteController()];
                $controllerSettings = [
                    'controller_name' => $settingsController,
                    'records_per_page' => $settingsController['records_per_page'],
                    'visibility' => serialize($controller->getVisibleColumns($columnString)),
                    'sortable' => serialize($controller->getSortableColumns($columnString)),
                    'searchable' => NULL,
                    'query_values' => serialize($settingsController['status_choices']),
                    'query' => $settingsController['query'],
                    'filter' => serialize($settingsController['filter_by']),
                    'alias' => $settingsController['filter_alias']
                ];
                $action = $controller->repository
                    ->getRepo()
                    ->getRepo()
                    ->getEm()
                    ->getCrud()
                    ->create($controllerSettings);

                if ($action) {
                    if ($action) {
                        $this->dispatchSingleActionEvent(
                            $controller,
                            $eventDispatcher,
                            $method,
                            $controller->repository->getRepo()->validatedDataBag(),
                            $additionalContext
                        );

                    }
                }
                $this->domainAction = $action;
            }
        endif;

        return $this;
    }
}
