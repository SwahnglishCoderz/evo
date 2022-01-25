<?php

namespace Evo\Base;

use App\Auth;
use App\Flash;
use Evo\Base\Exception\BaseBadMethodCallException;
use Evo\Base\BaseApplication;
//use Evo\Base\Events\BeforeRenderActionEvent;
//use Evo\Base\Events\BeforeControllerActionEvent;
use Evo\Base\Traits\ControllerMenuTrait;
use Evo\Base\Traits\ControllerPrivilegeTrait;
use Evo\Utility\Yaml;
use Evo\Base\BaseView;
use Evo\Auth\Authorized;
use Evo\Base\BaseRedirect;
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
    public function redirect(string $url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
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
}