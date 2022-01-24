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

namespace Evo\Usermanager\PasswordRecovery\Form;

use Evo\FormBuilder\ClientFormBuilder;
use Evo\FormBuilder\ClientFormBuilderInterface;
use Evo\FormBuilder\FormBuilderBlueprint;
use Evo\FormBuilder\FormBuilderBlueprintInterface;
use Exception;

class PasswordForm extends ClientFormBuilder implements ClientFormBuilderInterface
{

    /** @var FormBuilderBlueprintInterface $blueprint */
    private FormBuilderBlueprintInterface $blueprint;

    /**
     * Main class constructor
     *
     * @param FormBuilderBlueprint $blueprint
     * @return void
     */
    public function __construct(FormBuilderBlueprint $blueprint)
    {
        $this->blueprint = $blueprint;
        parent::__construct();
    }

    /**
     * @param string $action
     * @param ?object $dataRepository
     * @param ?object $callingController
     * @return string
     * @throws Exception
     */
    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null): string
    {
        return $this->form(['action' => $action, 'class' => 'uk-form-stacked'])
            ->addRepository($dataRepository)
            ->add(
                $this->blueprint->email('email', [], null, true, false, 'Email Address'),
                null,
                $this->blueprint->settings(false, null, false)
            )
            ->add(
                $this->blueprint->submit(
                    'forgot-password',
                    ['uk-button', 'uk-button-primary'],
                    'Send Password Reset Email'
                ),
                null,
                $this->blueprint->settings(false, null, false, null, true)
            )
            ->build(['before' => '<div class="uk-margin">', 'after' => '</div>']
            );

    }

}
