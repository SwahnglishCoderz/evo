<?php

namespace Evo\Base;

use App\Auth;
use App\Flash;
use Evo\Base\BaseApplication;
use Evo\Base\BaseRedirect;
use Evo\Base\Exception\BaseBadMethodCallException;
use Evo\Ash\Exception\FileNotFoundException;
//use Evo\Base\Events\BeforeRenderActionEvent;
//use Evo\Base\Events\BeforeControllerActionEvent;
use Evo\Base\Traits\ControllerMenuTrait;
use Evo\Base\Traits\ControllerPrivilegeTrait;
use Evo\Utility\Yaml;
use Evo\Base\BaseView;
use Evo\Auth\Authorized;
//use Evo\Session\Flash\Flash;
use Evo\Session\SessionTrait;
use Evo\Ash\TemplateExtension;
use Evo\Middleware\Middleware;
use Evo\Session\Flash\FlashType;
use Evo\Base\Exception\BaseLogicException;
use Evo\Base\Traits\ControllerCastingTrait;
use Evo\Auth\Roles\PrivilegedUser;
use Evo\UserManager\UserModel;
use Evo\UserManager\Rbac\Permission\PermissionModel;
use Exception;

class BaseController extends AbstractBaseController
{
    use SessionTrait;
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
//        $this->templateEngine = new BaseView();

//        $this->diContainer(Config::PROVIDERS);
//        $this->initEvents();
//        $this->buildControllerMenu($routeParams);
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
//        $method = $name;

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new BaseBadMethodCallException("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     */
    protected function after()
    {
    }

    /**
     * Redirect to a different page
     */
//    public function redirect(string $url)
//    {
//        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
//        exit;
//    }

    public function redirect(string $url, bool $replace = true, int $responseCode = 303)
    {
//        print_r($_SESSION);
//        exit;
        $this->redirect = new BaseRedirect(
            $url,
            $this->routeParams,
            $replace,
            $responseCode
        );

//        print_r($this->redirect);
//        exit;

        if ($this->redirect) {
            $this->redirect->redirect();
        }
    }

    /**
     * Require the user to be logged in before giving access to the requested page.
     * Remember the requested page for later, then redirect to the login page.
     */
    public function requireLogin()
    {
        if (! Auth::getUser()) {

            Flash::addMessageToFlashNotifications('Please log in to access that page', Flash::INFO);

            Auth::rememberRequestedPage();

            $this->redirect('/login');
        }
    }

    /**
     * Return and instance of the base application class
     */
    public function baseApp()
    {
        return new BaseApplication();
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    public function getRoutes(): array
    {
        return $this->routeParams;
    }

    /**
     * Returns the session object for use throughout any controller. Can be used
     * to call any of the methods defined with the session class
     */
    public function getSession(): object
    {
        return SessionTrait::sessionFromGlobal();
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
     * Combination method which encapsulate the flashing and redirecting all within
     * a single method. Use the relevant arguments to customize the output
     */
    public function flashAndRedirect(bool $action, ?string $redirect = null, string $message, string $type = FlashType::SUCCESS): void
    {
        if (is_bool($action)) {
            $this->flashMessage($message, $type);
            $this->redirect(($redirect === null) ? $this->onSelf() : $redirect);
        }
    }

    /**
     * Returns the session based flash message
     */
    public function flashMessage(string $message, string $type = FlashType::SUCCESS)
    {
        $flash = (new Flash(SessionTrait::sessionFromGlobal()))->add($message, $type);
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