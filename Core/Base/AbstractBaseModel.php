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

namespace Evo\Base;

use Evo\Base\BaseModel;

Abstract class AbstractBaseModel extends BaseModel
{
    /**
     * return an array of ID for which the system will prevent from being
     * deleted
     */
    abstract public function guardedID() : array;

}