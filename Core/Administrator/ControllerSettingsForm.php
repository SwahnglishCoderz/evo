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

use Exception;
use Evo\Base\BaseController;
use Evo\FormBuilder\ClientFormBuilder;
use Evo\FormBuilder\ClientFormBuilderInterface;
use Evo\FormBuilder\FormBuilderBlueprint;
use Evo\FormBuilder\FormBuilderBlueprintInterface;

class ControllerSettingsForm extends ClientFormBuilder implements ClientFormBuilderInterface
{
    private FormBuilderBlueprintInterface $blueprint;

    public function __construct(FormBuilderBlueprint $blueprint)
    {
        $this->blueprint = $blueprint;
        parent::__construct();
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null): string
    {
        $controller = new BaseController([]);
        return $this->form(['action' => $action, 'class' => ['uk-form-stacked'], "id" => "tableForm"])
            ->addRepository($dataRepository)
            ->add(
                $this->blueprint->text(
                    'records_per_page',
                    ['uk-form-width-small', 'uk-form-small', 'uk-form-blank', 'border-bottom'],
                    $this->hasValue('records_per_page'),
                    false,
                    'Records Per page'
                ),
                null,
                $this->blueprint->settings(false, null, false, '', true)
            )
            ->add(
                $this->blueprint->text(
                    'query',
                    ['uk-form-width-medium', 'uk-form-small', 'uk-form-blank', 'border-bottom'],
                    $this->hasValue('query'),
                    false,
                    'Query'
                ),
                null,
                $this->blueprint->settings(false, null, false, '', true)
            )
            ->add(
                $this->blueprint->text(
                    'alias',
                    ['uk-form-width-medium', 'uk-form-small', 'uk-form-blank', 'border-bottom', 'uk-margin-small-bottom'],
                    $this->hasValue('alias'),
                    false,
                    'Filter Alias'
                ),
                null,
                $this->blueprint->settings(false, null, false, '', true)
            )
            ->add(
                $this->blueprint->submit(
                    'settings-' . $callingController->thisRouteController() . '',
                    ['uk-button', 'uk-button-primary', 'uk-button-small'],
                    'Save'
                ),
                null,
                $this->blueprint->settings(false, null, false, null, true)
            )
            ->build(['before' => '<div class="uk-margin">', 'after' => '</div>']);
    }
}
