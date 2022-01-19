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

namespace Evo\Orm\DataRepository;

use Evo\Orm\EntityManager\EntityManagerInterface;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    /**
     * Main class constructor which requires the entity manager object. This object
     * is passed within the data repository factory.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getClientCrud(): object
    {
        return $this->em->getCrud();
    }

    /**
     * @throws Throwable
     */
    public function save(array $fields = [], ?string $primaryKey = null): bool
    {
        try {
            if (is_array($fields) && count($fields) > 0) {
                if ($primaryKey != null && is_string($primaryKey)) {
                    return $this->em->getCrud()->update($fields, $primaryKey);
                } elseif ($primaryKey === null) {
                    return $this->em->getCrud()->create($fields);
                }
            }
        } catch (Throwable $throw) {
            throw $throw;
        }
    }

    /**
     * @throws Throwable
     */
    public function drop(array $condition): bool
    {
        try {
            if (is_array($condition) && count($condition) > 0) {
                return $this->em->getCrud()->delete($condition);
            }
        } catch (Throwable $throw) {
            throw $throw;
        }
    }

    /**
     * @throws Throwable
     */
    public function get(array $conditions = []): array
    {
        try {
            return $this->em->getCrud()->read([], $conditions);
        } catch (Throwable $throw) {
            throw $throw;
        }
    }


    public function validate(): void
    {
    }
}
