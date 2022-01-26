<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Evo\Administrator\Controller;

use Evo\Administrator\ControllerSettingsForm;
use Evo\Administrator\ControllerSettingsModel;
use Evo\Administrator\ControllerSettingsEntity;
use Evo\Administrator\Event\ControllerSettingsActionEvent;
use Evo\Administrator\Middleware\Before\AdminAuthentication;
use Evo\Administrator\Middleware\Before\AuthorizedIsNull;
use Evo\Administrator\Middleware\Before\LoginRequired;
use Evo\Administrator\Middleware\Before\SessionExpires;
use Evo\Auth\Roles\Roles;
use Evo\Base\Access;
use Evo\Base\BaseController;
use Evo\Base\Domain\Actions\BlankAction;
use Evo\Base\Domain\Actions\BulkDeleteAction;
use Evo\Base\Domain\Actions\BulkCloneAction;
use Evo\Base\Domain\Actions\ChangeRowsAction;
use Evo\Base\Domain\Actions\ChangeStatusAction;
use Evo\Base\Domain\Actions\DeleteAction;
use Evo\Base\Domain\Actions\EditAction;
use Evo\Base\Domain\Actions\IndexAction;
use Evo\Base\Domain\Actions\LogIndexAction;
use Evo\Base\Domain\Actions\NewAction;
use Evo\Base\Domain\Actions\CloneAction;
use Evo\Base\Domain\Actions\SettingsAction;
use Evo\Base\Domain\Actions\ShowAction;
use Evo\Base\Domain\Actions\ShowBulkAction;
use Evo\Base\Domain\Actions\SimpleCreateAction;
use Evo\Base\Domain\Actions\SimpleUpdateAction;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Base\Traits\TableSettingsTrait;
use Evo\Datatable\Datatable;
use Evo\RestFul\RestHandler;
use Evo\Session\SessionTrait;
use Evo\Settings\Entity\ControllerSettingEntity;
use Evo\Settings\Event\ControllerSettingActionEvent;
use Evo\Administrator\Middleware\Before\IntegrityConstraints;
use Evo\UserManager\Event\UserActionEvent;
use Evo\UserManager\Forms\Admin\BulkDeleteForm;

class AdminController extends BaseController
{

    use SessionTrait;
    use TableSettingsTrait;

    /**
     * Extends the base constructor method. Which gives us access to all the base
     * methods implemented within the base controller class.
     * Class dependency can be loaded within the constructor by calling the
     * container method and passing in an associative array of dependency to use within
     * the class
     *
     * @param array $routeParams
     * @return void
     * @throws BaseInvalidArgumentException
     */
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);

        /**
         * Dependencies are defined within an associative array like example below
         * [ userModel => \App\Model\UserModel::class ]. Where the key becomes the
         * property for the userModel object like so $this->userModel->getRepo();
         */
        $this->diContainer(
            [
                'tableGrid' => Datatable::class,
                'blankAction' => BlankAction::class,
                'simpleUpdateAction' => SimpleUpdateAction::class,
                'simpleCreateAction' => SimpleCreateAction::class,
                'newAction' => NewAction::class,
                'editAction' => EditAction::class,
                'deleteAction' => DeleteAction::class,
                'bulkDeleteAction' => BulkDeleteAction::class,
                'bulkCloneAction' => BulkCloneAction::class,
                'showBulkAction' => ShowBulkAction::class,
                'indexAction' => IndexAction::class,
                'cloneAction' => CloneAction::class,
                'logIndexAction' => LogIndexAction::class,
                'showAction' => ShowAction::class,
                'changeStatusAction' => ChangeStatusAction::class,
                'settingsAction' => SettingsAction::class,
                'apiResponse' => RestHandler::class,
                'changeRowsAction' => ChangeRowsAction::class,
                'controllerSettingsForm' => ControllerSettingsForm::class,
                'controllerRepository' => ControllerSettingsModel::class,
                'bulkDeleteForm' => BulkDeleteForm::class

            ]
        );

    }

    /**
     * Middleware which are executed before any action methods is called
     * middlewares are return within an array as either key/value pair. Note
     * array keys should represent the name of the actual class its loading ie
     * upper camel case for array keys. alternatively array can be defined as
     * an index array omitting the key entirely
     */
    protected function callBeforeMiddlewares(): array
    {
        return [
            'LoginRequired' => LoginRequired::class,
            'AdminAuthentication' => AdminAuthentication::class,
            'AuthorizedIsNull' => AuthorizedIsNull::class,
            'SessionExpires' => SessionExpires::class,
            //'IntegrityConstraints' => IntegrityConstraints::class
        ];
    }

    /**
     * After filter which is called after every controller. Can be used
     * for garbage collection
     */
    protected function callAfterMiddlewares(): array
    {
        return [];
    }

    /**
     * Returns the method path as a string to use with the redirect method.
     * The method will generate the necessary redirect string based on the
     * current route.
     */
    public function getRoute(string $action, object $controller): string
    {
        $self = '';
        if (!empty($this->thisRouteID()) && $this->thisRouteID() !== false) {
            if ($this->thisRouteID() === $this->findOr404()) {
                $route = "/{$this->thisRouteNamespace()}/{$this->thisRouteController()}/{$this->thisRouteID()}/{$this->thisRouteAction()}";
            }
        } else {
            $self = "/{$this->thisRouteNamespace()}/{$this->thisRouteController()}/{$action}";
        }

       // if ($self) {
            return $self;
        //}
    }

    /**
     * Checks whether the entity settings is being called from the correct
     * controller and return true. returns false otherwise
     *
     * @param string $autoController
     * @return boolean
     */
    private function isControllerValid(string $autoController): bool
    {
        if (is_array($this->routeParams) && in_array($autoController, $this->routeParams, true)) {
            if (isset($this->routeParams['controller']) && $this->routeParams['controller'] == $autoController) {
                return true;
            }
        }
        return false;
    }

    /**
     * Global 
     */
    protected function changeRowsAction()
    {
        $this->changeRowsAction
            ->execute($this, ControllerSettingEntity::class, ControllerSettingActionEvent::class, NULL, __METHOD__)
            ->endAfterExecution();
    }

    protected function settingsAction()
    {
        $this->editAction
            ->execute(
                $this, 
                ControllerSettingsEntity::class, 
                ControllerSettingsActionEvent::class, 
                NULL, 
                __METHOD__
            );
    }


}
