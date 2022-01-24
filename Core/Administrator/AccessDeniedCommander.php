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

namespace Evo\Administrator;

use Evo\CommanderBar\ApplicationCommanderInterface;
use Evo\CommanderBar\ApplicationCommanderTrait;
use Evo\CommanderBar\CommanderUnsetterTrait;
use Exception;

class AccessDeniedCommander implements ApplicationCommanderInterface
{
    use ApplicationCommanderTrait;
    use CommanderUnsetterTrait;

    /**
     * Return an array of all the inner routes within the user model
     */
    protected const INNER_ROUTES = [
        'index',
    ];

    private array $noCommander = [];
    private array $noNotification = self::INNER_ROUTES;
    private array $noCustomizer = self::INNER_ROUTES;
    private array $noManager = self::INNER_ROUTES;
    private array $noAction = self::INNER_ROUTES;
    private array $noFilter = self::INNER_ROUTES;

    private object $controller;

    /**
     * Get the specific yaml file which helps to render some text within the specified
     * html template.
     * @throws Exception
     */
    public function getYml(): array
    {
        return $this->findYml('accessDenied');
    }

    /**
     * Display a sparkline graph for this controller index route
     */
    public function getGraphs(): string
    {
        return '';
    }

    /**
     * Dynamically change commander bar header based on the current route
     * @throws Exception
     */
    public function getHeaderBuild(object $controller): string
    {
        $this->getHeaderBuildException($controller, self::INNER_ROUTES);
        $this->controller = $controller;

        switch ($controller->thisRouteAction()) {
            case 'index':
                return 'Access Denied';
                break;
            default:
                return 'Unknown';
                break;
        }
    }

}
