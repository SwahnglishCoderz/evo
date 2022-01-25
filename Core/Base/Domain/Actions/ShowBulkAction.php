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

/**
 * Class which handles the domain logic when adding a new item to the database
 * items are sanitized and validated before persisting to database. The class will 
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class ShowBulkAction implements DomainActionLogicInterface
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

        $formBuilder = $controller->formBuilder;
        if (!array_key_exists($controller->repository->getSchemaID(), $formBuilder->getData())) {
            $icon = '<ion-icon name="warning-outline"></ion-icon>';
            $controller->flashMessage("{$icon} Items must be selected in order to perform this action. No items have been changed.", $controller->flashWarning());
            $redirectPath = '/admin/' . $controller->thisRouteController() . '/index';
            $controller->redirect($redirectPath);
        }

        return $this;
    }
}
