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

namespace Evo\Error;

interface ErrorInterface
{

    public function addError($error, Object $object, array $errorParams = []): Error;
    public function getErrors(): array;
    public function getErrorParams(): array;
    public function dispatchError(?string $redirectPath);
    public function or(string $redirect, ?string $message = null): bool;
    public function hasError(): bool;
    public function getErrorCode(): string;
}
