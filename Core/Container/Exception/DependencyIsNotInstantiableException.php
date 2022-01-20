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

namespace Evo\Container\Exception;

use Evo\Container\NotFoundExceptionInterface;

/** PSR-11 Container */
class DependencyIsNotInstantiableException extends ContainerException implements NotFoundExceptionInterface
{
}
