<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Evo\Orm\ClientRepository;

use Exception;
use Evo\Utility\Stringify;
use Evo\Base\BaseApplication;

trait ClientRelationshipTrait
{

    /**
     * @throws Exception
     */
    public function findManyToMany(string $tablePivot)
    {
        if ($tablePivot) {
            $newPivotObject = BaseApplication::diGet($tablePivot);
            if (!$newPivotObject) {
                throw new Exception();
            }
            /* explode the pivot table string and extract both associative tables */
            $tableNames = explode('_', $newPivotObject->getSchema());
            if (is_array($tableNames) && count($tableNames) > 0) {
                $test = array_filter($tableNames, function($tableName) {
                    $suffix = 'Model';
                    $namespace = '\App\Model\\';
        
                    if (is_string($tableName)) {
                        $modelNameSuffix = $tableName . $suffix;
                        $modelName = Stringify::convertToStudlyCaps($modelNameSuffix);
                        if (class_exists($newModelClass = $namespace . $modelName)) {
                            $newModelObject = BaseApplication::diGet($newModelClass);
                            if (!$newModelObject) {
                                throw new Exception();
                            }

                        }
                        return $newModelObject;

                    }
                });
                var_dump($test);
                die;
            }
        }
    }

}