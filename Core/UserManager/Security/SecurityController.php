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

namespace Evo\UserManager\Security;

use Evo\UserManager\Security\Event\LoginActionEvent;
use Evo\UserManager\Security\Event\LogoutActionEvent;
use Evo\UserManager\Security\Form\LoginForm;
use Evo\UserManager\Security\Form\LogoutForm;
use Evo\UserManager\Security\Middleware\Before\isAlreadyLogin;
use Evo\UserManager\Security\Middleware\Before\isUserAccountActivated;
use Evo\Auth\Authenticator;
use Evo\Base\BaseController;
use Evo\Base\Domain\Actions\LoginAction;
use Evo\Base\Domain\Actions\LogoutAction;
//use Evo\Base\Domain\Actions\SessionExpiredAction;
use Evo\Base\Exception\BaseInvalidArgumentException;

class SecurityController extends BaseController
{

    /**
     * Extends the base constructor method. Which gives us access to all the base
     * methods implemented within the base controller class.
     * Class dependency can be loaded within the constructor by calling the
     * container method and passing in an associative array of dependency to use within
     * the class
     */
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
        /**
         * Dependencies are defined within a associative array like example below
         * [ userModel => \App\Model\UserModel::class ]. Where the key becomes the
         * property for the userModel object like so $this->userModel->getRepo();
         */
        $this->diContainer(
            [
                'loginForm' => LoginForm::class,
                'logoutForm' => LogoutForm::class,
//                'sessionExpiredAction' => SessionExpiredAction::class,
                'authenticator' => Authenticator::class,
                'loginAction' => LoginAction::class,
//                'logoutAction' => LogoutAction::class,
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
//            'isUserAccountActivated' => isUserAccountActivated::class,
//            'isAlreadyLogin' => isAlreadyLogin::class,
        ];
    }

    /**
     * Entry method which is hit on request. This method should be implement within
     * all sub controller class as a default landing point when a request is
     * made.
     */
    protected function indexAction()
    {
        $this->loginAction
            ->execute($this, NULL, LoginActionEvent::class, NULL, __METHOD__)
            ->render()
            ->with()
            ->form($this->loginForm)
            ->end();

    }

    /**
     * @return void
     */
    protected function sessionAction()
    {
        $this->render('client/security/session.html', []);
    }

}
