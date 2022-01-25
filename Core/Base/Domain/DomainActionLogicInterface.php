<?php

declare(strict_types = 1);

namespace Evo\Base\Domain;

interface DomainActionLogicInterface
{

    /**
     * Logic execution
     */
    public function execute(
        Object $controller,
        ?string $entityObject,
        ?string $eventDispatcher,
        ?string $objectSchema,
        string $method,
        array $rules = [],
        array $additionalContext = [],
        $optional = null
    ): self;
    
    /**
     * Undocumented function
     */
    public function render(?string $filename = null, int $extension = 2): self;

    /**
     * Undocumented function
     */
    public function with(array $context = []): self;
    
    /**
     * Undocumented function
     */
    public function form(Object $formRendering, ?string $formAction = null, $data = null): self;

    /**
     * Undocumented function
     */
    public function table(array $tableParams = [], ?object $column = null, ?object $repository = null, array $tableData = []): self;

    /**
     * Undocumented function
     */
    public function end(?string $type = null): void;
}
