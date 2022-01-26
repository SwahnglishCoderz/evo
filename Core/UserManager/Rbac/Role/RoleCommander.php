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

namespace Evo\UserManager\Rbac\Role;

use Exception;
use Evo\CommanderBar\ApplicationCommanderInterface;
use Evo\CommanderBar\ApplicationCommanderTrait;
use Evo\CommanderBar\CommanderUnsetterTrait;

class RoleCommander extends RoleModel implements ApplicationCommanderInterface
{

    use ApplicationCommanderTrait;
    use CommanderUnsetterTrait;

    /**
     * Return an array of all the inner routes within the user model
     * @var array
     */
    protected const INNER_ROUTES = [
        'index',
        'new',
        'edit',
        'assigned',
        'log',
        'bulk'
    ];

    private array $noCommander = [];
    private array $noNotification = self::INNER_ROUTES;
    private array $noCustomizer = ['edit', 'new', 'assigned'];
    private array $noManager = ['new'];
    private array $noAction = [];
    private array $noFilter = ['new', 'edit', 'assigned'];

    private object $controller;

    /**
     * Get the specific yaml file which helps to render some text within the specified
     * html template.
     * @throws Exception
     */
    public function getYml(): array
    {
        return $this->findYml('role');
    }

    /**
     * Display a sparkline graph for this controller index route
     */
    public function getGraphs(): string
    {
        return '<div id="sparkline"></div>';
    }

    /**
     * Dynamically change commander bar header based on the current route
     *
     * @param object $controller
     * @return string
     * @throws Exception
     */
    public function getHeaderBuild(object $controller): string
    {
        $this->getHeaderBuildException($controller, self::INNER_ROUTES);

        $this->controller = $controller;
        return match ($controller->thisRouteAction()) {
            'index' => $this->getStatusColumnFromQueryParams($controller),
            'new' => 'Create New Role',
            'edit' => "Edit " . $this->getHeaderBuildEdit($controller, 'role_name'),
            'assigned' => 'Role Assignment',
            'bulk' => 'Bulk',
            default => "Unknown"
        };
    }


}
