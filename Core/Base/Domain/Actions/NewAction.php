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
class NewAction implements DomainActionLogicInterface
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

            if ($formBuilder->csrfValidate()) {
                $entityCollection = $controller->repository->getEntity()->wash($this->isAjaxOrNormal())->rinse()->dry();

                $action = $controller->repository
                    ->getRepo()
                    ->validateRepository($entityCollection, $entityObject, null, $controller)
                    ->persistAfterValidation();

                if ($action) {
                    $this->dispatchSingleActionEvent(
                        $controller,
                        $eventDispatcher,
                        $method,
                        $controller->repository->getRepo()->validatedDataBag(),
                        $additionalContext
                    );

                }
                $this->domainAction = $action;

            }

        endif;
        return $this;
    }
}
