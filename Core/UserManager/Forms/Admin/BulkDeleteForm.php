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

namespace Evo\UserManager\Forms\Admin;

use Exception;
use Evo\FormBuilder\ClientFormBuilder;
use Evo\FormBuilder\ClientFormBuilderInterface;

class BulkDeleteForm extends ClientFormBuilder implements ClientFormBuilderInterface
{

    /**
     * @param string $action
     * @param ?object $dataRepository
     * @param ?object $callingController
     * @return string
     * @throws Exception
     */
    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null): string
    {
        if ($dataRepository != null) {
            $dataRepository = (array)$dataRepository;
            extract($dataRepository);
        }
        return '';
    }
}
