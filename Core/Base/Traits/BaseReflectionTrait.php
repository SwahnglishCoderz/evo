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

namespace Evo\Base\Traits;

use ReflectionClassConstant;
//use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

trait BaseReflectionTrait
{

    public function __construct()
    {
        defined('__REF_PROTECTED__') or define('__REF_PROTECTED__', ReflectionMethod::IS_PROTECTED);
        defined('__REF_PRIVATE__') or define('__REF_PRIVATE', ReflectionMethod::IS_PRIVATE);
        defined('__REF_PUBLIC__') or define('__REF_PUBLIC__', ReflectionMethod::IS_PUBLIC);
    }

    /**
     * @throws ReflectionException
     */
    public function reflection(string $name): self
    {
        if ($name) {
            $this->name = $name;
            $this->reflection = new ReflectionClass($name);
        }
        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function instance($args): object
    {
        return $this->reflection->newInstance($args);
    }

    /**
     * @throws ReflectionException
     */
    public function instanceArgs(array $args = []): object
    {
        return $this->reflection->newInstanceArgs($args);
    }

    public function hasMethod(string $name)
    {
        $has = $this->reflection->hasMethod($name);
        return is_bool($has) && $has === true ? $this->method($name) : false;
    }

    /**
     * @throws ReflectionException
     */
    public function method(?string $name = null): ReflectionMethod
    {
        return $this->reflection->getMethod($name);
    }

    public function methods(?int $filters = null): array
    {
        return $this->reflection->getMethods($filters);
    }

    public function namespace(): string
    {
        return $this->reflection->getNamespaceName();
    }

    public function parent()
    {
        if (!false)
            return $this->reflection->getParentClass();
    }

    public function props(?int $filters = null): array
    {
        return $this->reflection->getProperties($filters);
    }

    public function hasProp(string $name)
    {
        $has = $this->reflection->hasProperty($name);
        return is_bool($has) && $has === true ? $this->prop($name) : false;

    }

    /**
     * @throws ReflectionException
     */
    public function prop(string $name): ReflectionProperty
    {
        return $this->reflection->getProperty($name);
    }

    public function hasConst(string $name)
    {
        $has = $this->reflection->hasConstant($name);
        return is_bool($has) && $has === true ? $this->const($name) : false;

    }

    public function const(string $name)
    {
        return $this->reflection->getConstant($name);
    }

    public function consts(?int $filters = null): array
    {
        return $this->reflection->getConstants($filters);
    }

    public function className(): string
    {
        return $this->reflection->getShortName();
    }

    public function comment()
    {
        return $this->reflection->getDocComment();
    }

    public function interfaces(): array
    {
        return $this->reflection->getInterfaces();
    }

    public function interfaceNames(): array
    {
        return $this->reflection->getInterfaceNames();
    }

    public function implements(string $interface): bool
    {
        return $this->reflection->implementsInterface($this->reflection, $interface);
    }

    public function fileName()
    {
        return $this->reflection->getFileName();
    }

    public function startLine()
    {
        return $this->reflection->getStartLine();
    }

    public function endLine()
    {
        return $this->reflection->getEndLine();
    }

    public function traits(): array
    {
        return $this->reflection->getTraits();
    }

    public function traitNames(): array
    {
        return $this->reflection->getTraitNames();
    }

    public function traitAlias()
    {
        return $this->reflection->getTraitAliases();
    }

    public function attr(?string $name = null, int $flag = 0)
    {
//        $this->attr = $this->reflection->getAttributes($name, $flag); // tafuta mbadala
        return $this;
    }

    public function attrDump()
    {
//        echo json_encode(array_map(fn(ReflectionAttribute $attr) => $attr->getName(), $this->attr));
    }

}