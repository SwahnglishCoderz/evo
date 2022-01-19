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

use Evo\Utility\Sanitizer;
use Evo\Collection\Collection;
use Evo\Base\Exception\BaseException;

class BaseEntity
{
    protected array $cleanData;
    protected array $dirtyData;
    protected ?object $dataSchemaObject;

    /**
     * BaseEntity constructor.
     * Assign the key which is now a property of this object to its array value
     */
    public function __construct()
    {}

    /**
     * Accept raw untreated data and prepare for sanitization
     * @throws BaseException
     */
    public function wash(array $dirtyData): BaseEntity
    {
        if (empty($dirtyData)) {
            throw new BaseException($dirtyData . 'has return null which means nothing was submitted.');
        }
        $this->dirtyData = $dirtyData;
        return $this;
    }

    /**
     * Ensure the data is of the correct data type before passing it through
     * the sanitization class
     * @throws BaseException
     */
    public function rinse(): BaseEntity
    {
        if (!is_array($this->dirtyData)) {
            throw new BaseException(getType($this->dirtyData) . ' is an invalid type for this object. Please return an array of submitted data.');
        }
        $this->cleanData = Sanitizer::clean($this->dirtyData);
        return $this;
    }

    /**
     * Return the clean data as a new collection object. Also allowing
     * accessing the individual submitted data property. By simple
     * calling the $this->(field_name)
     */
    public function dry(): Collection
    {
        foreach ($this->cleanData as $key => $value) {
            $this->$key = $value;
        }
        return new Collection($this->cleanData);
    }
}
