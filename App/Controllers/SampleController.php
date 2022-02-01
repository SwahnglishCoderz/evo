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

namespace App\Controllers;

use Evo\Base\BaseView;
use Throwable;


class SampleController extends Authenticated
{
    /**
     * Items index
     * @throws Throwable
     */
    public function indexAction()
    {
        BaseView::renderTemplate('sample/index.html');
    }

    /**
     * Add a new sample
     */
    public function newAction()
    {
        echo "new action";
    }

    /**
     * Show a sample
     */
    public function showAction()
    {
        echo "show action";
    }
}
