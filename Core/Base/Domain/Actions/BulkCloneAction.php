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
 * items are sanitizedd and validated before persisting to database. The class will 
 * also dispatched any validation error before persistence. The logic also implements
 * event dispatching which provide usable data for event listeners to perform other
 * necessary tasks and message flashing
 */
class BulkCloneAction implements DomainActionLogicInterface
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
            $formData = $this->isAjaxOrNormal();
            $schemaID = $controller->repository->getSchemaID();
            $_newClone = [];

            if ($this->isArrayGood($formData)) {
                unset($formData[$this->getSubmitValue()]);
                $suffix = '-clone';
                $action = '';

                foreach (array_map('intval', $formData[$schemaID]) as $itemID) {
                    if ($itemID !==null) {
                        $itemObject = $controller->repository
                        ->getRepo()
                        ->findObjectBy(
                            [$schemaID => $itemID], 
                            $controller->repository->getClonableKeys()
                        );
                        $itemObjectToArray = $controller->toArray($itemObject);

                        /* new clone modified firstname, lastname and email strings */
                        $modifiedArray = array_map(
                            fn($item) => $this->resolvedCloning($item),
                            $itemObjectToArray
                        );

                        $baseArray = $controller->repository
                        ->getRepo()
                        ->findOneBy([$schemaID => $itemID]);

                        /* merge the modifiedArray with the baseArray overriding any key from the baseArray */
                        $newCloneArray = array_map(
                            fn($array) => array_merge($array, $modifiedArray), 
                            $baseArray
                        );
                        $newClone = $this->flattenArray($newCloneArray);
                        /* We want the id to auto incremented so we will remove the id key from the array */
                        $_newClone = $controller->repository->unsetCloneKeys($newClone);

                        /* Now lets insert the clone data within the database */
                        $action = $controller->repository
                        ->getRepo()
                        ->getEm()
                        ->getCrud()
                        ->create($_newClone);
                                
                    }
                }

                if ($action) {
                    $this->dispatchSingleActionEvent(
                        $controller,
                        $eventDispatcher,
                        $method,
                        ['action' => $action, 'new_clone' => $_newClone],
                        $additionalContext
                    );

                }

            }
        endif;
        return $this;
    }    

}
