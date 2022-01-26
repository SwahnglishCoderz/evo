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

namespace Evo\FormBuilder;

interface FormBuilderBlueprintInterface
{
    /**
     * Undocumented function
     */
    public function text(
        string $name,
        array $class = [],
        $value = null,
        bool $disabled = false,
        ?string $placeholder = null
    ): array;

    /**
     * Undocumented function
     */
    public function hidden(
        string $name,
        $value = null,
        array $class = []
    ): array;

    public function textarea(
        string $name,
        array $class = [],
        $id = null,
        ?string $placeholder = null,
        int $rows = 5,
        int $cols = 33
    ): array;

    public function email(
        string $name,
        array $class = [],
        $value = null,
        bool $required = true,
        bool $pattern = false,
        ?string $placeholder = null
    ): array;

    public function password(
        string $name,
        array $class = [],
        $value = null,
        ?string $autocomplete = null,
        bool $required = false,
        bool $pattern = false,
        bool $disabled = false,
        ?string $placeholder = null
    ): array;

    /**
     * Undocumented function
     */
    public function radio(string $name, array $class = [], $value = null): array;

    public function submit(
        string $name,
        array $class = [],
        $value = null
    ): array;

    public function checkbox(
        string $name,
        array $class = [],
        $value = null
    ): array;

    public function select(
        string $name,
        array $class = [],
        string $id = null,
        $value = null,
        bool $multiple = false
    ): array;

    public function multipleCheckbox(
        string $name,
        array $class = [],
        $value = null
    ): array;

    /**
     * Undocumented function
     */
    public function choices(array $choices, $default = null, object $form = null): array;

    /**
     * Undocumented function
     */
    public function settings(
        bool $inlineIcon = false,
        string $icon = null,
        bool $showLabel = true,
        string $newLabel = null,
        bool $wrapper = false,
        ?string $checkboxLabel = null,
        ?string $description = null
    ): array;
}
