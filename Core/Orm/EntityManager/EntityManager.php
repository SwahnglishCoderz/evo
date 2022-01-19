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

namespace Evo\Orm\EntityManager;

class EntityManager implements EntityManagerInterface
{
    protected CrudInterface $crud;

    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    public function getCrud() : Object
    {
        return $this->crud;
    }

}
