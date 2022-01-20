<?php

namespace Evo\Base;

use Evo\Base\Exception\BaseBadMethodCallException;

class BaseController extends AbstractBaseController
{
    public function __construct()
    {
        parent::__construct();
//        $this->routeParams = $routeParams;
//        $this->templateEngine = new BaseView();

//        $this->diContainer(Yaml::file('providers'));
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
//        $method = $name . 'Action';
        $method = $name;

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
    {}

    /**
     * After filter - called after an action method.
     */
    protected function after()
    {}
}