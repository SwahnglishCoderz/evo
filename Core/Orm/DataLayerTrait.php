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

namespace Evo\Orm;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

trait DataLayerTrait
{
    /**
     * Returns a flatted array from a multidimensional array
     */
    public function flattenArray(array $array = null): array
    {
        if (is_array($array)) {
            $arraySingle = [];
            foreach ($array as $arr) {
                foreach ($arr as $val) {
                    $arraySingle[] = $val;
                }
            }
            return $arraySingle;
        }
    }

    /**
     * Returns a flatted array from a multidimensional array recursively
     */
    public function flattenArrayRecursive(array $array = null): array
    {
        $flatArray = array();
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $value) {
            $flatArray[] = $value;
        }
        return $flatArray;
    }

}
