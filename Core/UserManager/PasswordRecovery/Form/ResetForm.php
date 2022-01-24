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

namespace Evo\UserManager\PasswordRecovery\Form;

use Evo\FormBuilder\ClientFormBuilder;
use Evo\FormBuilder\ClientFormBuilderInterface;
use Evo\FormBuilder\FormBuilderBlueprint;
use Evo\FormBuilder\FormBuilderBlueprintInterface;
use Evo\FormBuilder\Type\HiddenType;
use Evo\FormBuilder\Type\PasswordType;
use Evo\FormBuilder\Type\SubmitType;
use Exception;

class ResetForm extends ClientFormBuilder implements ClientFormBuilderInterface
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
                $this->blueprint->password('password_hash', ['uk-form-width-large']),
                null,
                $this->blueprint->settings(false, null, true, 'New Password')
            )
            ->add($this->blueprint->hidden('token', $dataRepository->token), null, ['show_label' => false])
            ->add(
                $this->blueprint->submit(
                    'reset-password',
                    ['uk-button', 'uk-button-primary'],
                    'Reset Password'
                ),
                null,
                $this->blueprint->settings(false, null, false, null, true)
            )
            ->build(['before' => '<div class="uk-margin">', 'after' => '</div>']);

    }

}
