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

namespace Evo\FormBuilder\Traits;

use JetBrains\PhpStorm\Pure;

trait FormalizerTrait
{

    /**
     * Add a model repository the form builder object
     *
     * @param ?object $repository
     * @return static
     */
    public function addRepository(object $repository = null)
    {
        if ($repository !==null) {
            $this->dataRepository = $repository;
        }
        return $this;
    }

    /**
     * Expose the model repository to the form builder object
     *
     * @return mixed
     */
    public function getRepository()
    {
        return $this->dataRepository;
    }

    /**
     * Undocumented function
     *
     * @param string $fieldName
     * @return mixed
     */
    #[Pure] public function hasValue(string $fieldName)
    {
        if (is_array($arrayRepo = $this->getRepository())) {
            return empty($arrayRepo[$fieldName]) ? '' : $arrayRepo[$fieldName];
        } elseif (is_object($objectRepo = $this->getRepository())) {
            return empty($objectRepo->$fieldName) ? '' : $objectRepo->$fieldName;
        } else {
            return false;
        }
    }

}