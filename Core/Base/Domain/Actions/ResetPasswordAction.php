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

use Evo\Base\Domain\DomainTraits;
use Evo\Base\Domain\DomainActionLogicInterface;

/**
 * Class which handles the domain logic when adding a new item to the database
 * items are sanitized and validated before persisting to database. The class will 
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class ResetPasswordAction implements DomainActionLogicInterface
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

        if (isset($formBuilder) && $formBuilder->isFormValid($this->getSubmitValue())) :
            if ($formBuilder->csrfValidate()) {

                $entityCollection = $controller->entity->wash($this->isAjaxOrNormal())->rinse()->dry();
                $repository = $controller->repository->findByPasswordResetToken($entityCollection['token']);

                $action = $controller->repository->validatePassword($entityCollection, $repository)->reset();
                if (is_bool($action) && $action !==true) {
                    if ($controller->error) {
                        $controller->error->addError(['error_saving' => 'Error saving new password.'], $controller)->dispatchError();
                    }
                }

                if ($action) {
                    $this->dispatchSingleActionEvent(
                        $controller,
                        $eventDispatcher,
                        $method,
                        ['action' => $action, $controller->toArray($repository)],
                        $additionalContext
                    );

                }

            }
        endif;

        return $this;
    }
}
