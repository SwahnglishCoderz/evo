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
class SimpleUpdateAction implements DomainActionLogicInterface
{

    use DomainTraits;

    protected bool $isRestFul = false;

    /**
     * execute logic for adding new items to the database(). Post data is returned as a collection
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

        if (isset($formBuilder) && $formBuilder->isFormValid($this->getSubmitValue())) :
                $entityCollection = $controller->userRole
                    ->getEntity()
                    ->wash($formBuilder->getData())
                    ->rinse()
                    ->dry();
                $data = $entityCollection->all();

            unset($data[$this->getSubmitValue()]); /* remove the submit from the final array */
                $controller->userRole
                    ->getRepo()
                    ->getEm()
                    ->getCrud()
                    ->update(
                        array_merge($data, $controller->userRoleRepo->getRepoUserIDArray($controller->thisRouteID())),
                        $controller->userRoleRepo->getRepoSchemaID()
                    );
                    $this->dispatchSingleActionEvent(
                        $controller,
                        $eventDispatcher,
                        $method,
                        array_merge($data, $additionalContext ? $additionalContext : []),
                        $additionalContext
                    );


        endif;
        return $this;
    }


}


