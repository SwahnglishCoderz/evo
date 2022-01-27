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

namespace Evo\UserManager\Rbac\Permission\Event;

use Evo\Base\BaseActionEvent;

class PermissionActionEvent extends BaseActionEvent
{

    /** name of the event */
    public const NAME = 'evo.usermanager.rbac.permission.event.permission_action_event';
}