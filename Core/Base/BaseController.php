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

use Evo\Flash\Flash;
use App\Models\PermissionModel;
use App\Models\UserModel;
use Evo\Auth\Authorized;
use Evo\Base\BaseApplication;
use Evo\Base\BaseRedirect;
use Evo\Base\Exception\BaseBadMethodCallException;
use Evo\Base\Middlewares\Error404;
use Evo\Base\Traits\ControllerMenuTrait;
use Evo\Base\Traits\ControllerPrivilegeTrait;
use Evo\Error\Error;
use Evo\Session\Flash\FlashType;
use Evo\System\Config;
use Evo\Base\BaseView;
use Evo\Middleware\Middleware;
use Evo\Base\Exception\BaseLogicException;
use Evo\Base\Traits\ControllerCastingTrait;
use Exception;
use Throwable;

class BaseController extends AbstractBaseController
{
    use ControllerCastingTrait;
    use ControllerPrivilegeTrait;
    use ControllerMenuTrait;

    protected array $routeParams;

    protected Object $templateEngine;
    protected object $template;

    protected array $callBeforeMiddlewares = [];
    protected array $callAfterMiddlewares = [];
    protected array $controllerContext = [];

    public function __construct(array $routeParams, array $menuItems = [])
    {
        parent::__construct($routeParams);
        $this->routeParams = $routeParams;
        $this->templateEngine = new BaseView();

//        $this->diContainer(Config::PROVIDERS);
//        $this->initEvents();
//        $this->buildControllerMenu($routeParams);
    }

    /**
     * Return and instance of the base application class
     */
    public function baseApp(): \Evo\Base\BaseApplication
    {
        return new BaseApplication();
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     */
    public function __call(string $name, array $args)
    {
        $method = $name . 'Action';
//        print_r($name);
//        exit;

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new BaseBadMethodCallException("Method $method not found in controller " . get_class($this));
        }
    }

    protected function defineCoreMiddleware(): array
    {
        return [
            'error404' => Error404::class
        ];
    }

    /**
     * Returns an array of middlewares for the current object which will
     * execute before the action is called. Middlewares are also resolved
     * via the container object. So you can also type hint any dependency
     * you need within your middleware constructor. Note constructor arguments
     * cannot be resolved only other objects
     */
    protected function callBeforeMiddlewares(): array
    {
        return array_merge($this->defineCoreMiddleware(), $this->callBeforeMiddlewares);
    }

    /**
     * Returns an array of middlewares for the current object which will
     * execute before the action is called. Middlewares are also resolved
     * via the container object. So you can also type hint any dependency
     * you need within your middleware constructor. Note constructor arguments
     * cannot be resolved only other objects
     */
    protected function callAfterMiddlewares(): array
    {
        return $this->callAfterMiddlewares;
    }

    /**
     * Before filter - called before an action method.
     */
    protected function before()
    {
        $object = new self($this->routeParams);
        (new Middleware())->middlewares($this->callBeforeMiddlewares())
            ->middleware($object, function ($object) {
                return $object;
            });
    }

    /**
     * After filter - called after an action method.
     */
    protected function after()
    {
        $object = new self($this->routeParams);
        (new Middleware())->middlewares($this->callAfterMiddlewares())
            ->middleware($object, function ($object) {
                return $object;
            });
    }

    /**
     * Redirect to a different page
     */
    public function redirect(string $url, bool $replace = true, int $responseCode = 303)
    {
        $this->redirect = new BaseRedirect(
            $url,
            $this->routeParams,
            $replace,
            $responseCode
        );

        if ($this->redirect) {
            $this->redirect->redirect();
        }
    }

    /**
     * Require the user to be logged in before giving access to the requested page.
     * Remember the requested page for later, then redirect to the login page.
     * @throws Exception
     * @throws Throwable
     */
    public function requireLogin()
    {
        if (! Authorized::getUser()) {

            Flash::addMessageToFlashNotifications('Please log in to access that page', Flash::INFO);

            Authorized::rememberRequestedPage();

            $this->redirect('/login');
        }
    }

    public function getRoutes(): array
    {
        return $this->routeParams;
    }

    public function onSelf()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
    }

    public function getSiteUrl(?string $path = null): string
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            ($path !== null) ? $path : $_SERVER['REQUEST_URI']
        );
    }

    /**
     * Returns the session based flash message
     */
    public function flashMessage(string $message, string $type = Flash::SUCCESS)
    {
        $flash = Flash::addMessageToFlashNotifications($message, $type);
        if ($flash) {
            return $flash;
        }
    }

    /**
     * Returns the session based flash message type warning as string
     */
    public function flashWarning(): string
    {
        return FlashType::WARNING;
    }

    /**
     * Returns the session based flash message type success as string
     */
    public function flashSuccess(): string
    {
        return FlashType::SUCCESS;
    }

    /**
     * Returns the session based flash message type danger as string
     */
    public function flashDanger(): string
    {
        return FlashType::DANGER;
    }

    /**
     * Returns the session based flash message type info as string
     */
    public function flashInfo(): string
    {
        return FlashType::INFO;
    }
}