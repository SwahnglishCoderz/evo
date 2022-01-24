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

namespace Evo\CommanderBar\Traits;

use Evo\Utility\Stringify;

trait ActionTrait
{

    private function actions(): string
    {

        if (isset($this->controller)) {
            if (in_array($this->controller->thisRouteAction(), $this->controller->commander->unsetAction())) {
                return '';
            }
        }

        $commander = PHP_EOL;
        $commander .= $this->commanderFiltering() ?? ''; // filtering
        $commander .= '<ul class="uk-iconnav">';
        $commander .= '<li>';
        $commander .= '<a href="/admin/' . $this->controller->thisRouteController() . '/log" uk-tooltip="View Log" class="ion-28">';
        $commander .= '<ion-icon name="reader-outline"></ion-icon>';
        $commander .= '</a>';
        $commander .= '</li>';
        $commander .= PHP_EOL;
        $commander .= '<li>';
        $commander .= '<a href="' . $this->actionPath() . '" uk-tooltip="Go Back" class="uk-button uk-button-primary uk-button-small uk-link-reset uk-link-toggle">';
        $commander .= $this->actionButton();
        $commander .= '</a>';
        $commander .= '</li>';
        $commander .= PHP_EOL;
        $commander .= '</ul>';

        return $commander;
    }


}