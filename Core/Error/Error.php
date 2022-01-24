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

use App\Config;
use Evo\Utility\Yaml;
use Exception;

class Error implements ErrorInterface
{
    protected array $errors = [];
    protected array $errorParams = [];
    protected ?string $errorCode = null;
    protected Object $object;
    protected bool $hasError = false;

    public const    SHORT_PASSWORD     = 'ERR_100MC',
        PASSWORD_LETTER    = 'ERR_150MC',
        PASSWORD_NUMBER    = 'ERR_200MC',
        INVALID_EMAIL      = 'ERR_250MC',
        EMPTY_FIELDS       = 'ERR_300MC';


    /**
     * Add an error to the error array
     */
    public function addError($error, Object $object, array $errorParams = []): Error
    {
        if ($error)
            $this->errors = $error;
        if ($object)
            $this->object = $object;
        return $this;
    }

    /**
     * Dispatched one or more errors if necessary
     */
    public function dispatchError(?string $redirectPath = null): ErrorInterface
    {
        if (is_array($this->errors) && count($this->errors) > 0) {
            $this->hasError = true; /* If array contains at least 1 element then we have an error */
            foreach ($this->errors as $error) {
                $keys = array_keys((array)$error);
                foreach ($error as $err) {
                    $this->errorCode = $keys[0];
                    $this->object->flashMessage($err, $this->object->flashWarning());
                    $this->object->redirect(($redirectPath !== null) ? $redirectPath : $this->object->onSelf());
                }
            }
        }
        $this->hasError = false;
        return $this;
    }

    /**
     * Return bool if the user was successfully updated.
     */
    public function or(string $redirect, ?string $message = null): bool
    {
        if (!$this->hasError) {
            $message = (null == !$message) ? $message : 'Changes Saved!';
            $this->object->flashMessage($message, $this->object->flashSuccess());
            $this->object->redirect($redirect);

            return true;
        }
        return false;
    }

    /**
     * Return Whether we have error or not
     */
    public function hasError(): bool
    {
        return $this->hasError;
    }

    /**
     * Returns the array of errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Returns an array of error parameters
     */
    public function getErrorParams(): array
    {
        return $this->errorParams;
    }

    /**
     * Undocumented function
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Returns the error which matches the error code and returned a formatted array
     * to be dispatched
     * @throws Exception
     */
    public static function display(string $code): array
    {
//        $error = Yaml::file('error')[$code];
        $error = Config::ERROR[$code];
        if ($error) {
            return [$code => $error];
        }
    }
}
