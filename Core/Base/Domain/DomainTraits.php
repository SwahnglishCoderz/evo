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

namespace Evo\Base\Domain;

use App\Config;
use Exception;
use Evo\Utility\Yaml;
use Evo\Utility\Stringify;
use Evo\Base\Exception\BaseOutOfBoundsException;
use Evo\Base\Exception\BaseBadMethodCallException;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Auth\Roles\PrivilegedUser;
use Evo\Base\Domain\DomainActionLogTrait;
use Evo\Base\Access;

trait DomainTraits
{

    use DomainActionLogTrait;

    protected array $allowedRules = [
        'password_required',
        'password_equal'
    ];

    /**
     * Unset the csrf token from the data array
     */
    public function removeCsrfToken(array $data)
    {
        if ($data) {
            unset($data['_CSRF_INDEX'], $data['_CSRF_TOKEN'], $data['settings-user']);
        }

    }

    /**
     * Returns the current template directory path
     */
    private function templateDir(): string
    {
        return TEMPLATE_PATH . DS . Config::ROUTES['template_dir'];
    }

    /**
     * Explode the name of the current method by double colon :: and remove the
     * Action suffix from the string. As the method name is the last element within
     * the array the use of array_key_last ensure we are getting the last element.
     */
    private function getFilename(): string
    {
        $parts = explode('::', str_replace('Action', '', $this->method));
        return $parts[array_key_last($parts)];
    }

    /**
     * Returns the current object namespace as lowercase
     */
    private function getNamespace(): string
    {
        return strtolower($this->controller->thisRouteNamespace());
    }

    /**
     * Returns the current controller object
     */
    private function controllerLowercase(): string
    {
        return strtolower($this->controller->thisRouteController());
    }

    /**
     * Get the template file extension from the twig config file. note [2]. this
     * referrers to the current index of our template file extension. Which is
     * defined in the config index in position 2
     *
     * extension example [0 => .html, 1 => .twig, 2 => .html.twig]
     * So depending on what extensions you are using
     */
    public function getFileExt(int $indexPos): string
    {
        return Config::TEMPLATE['template']['template_ext'][$indexPos];
    }

    /**
     * Append the client directory name when dealing with non-dynamic routes ie
     * routes which doesn't define a dynamic namespace within the route.yml file
     */
    public function fileDirectoryFromNamespace(): string
    {
        if (empty($this->getNamespace()) || $this->getNamespace() == '') {
            return Config::ROUTES['client_dir'] . '/';
        }
        return $this->getNamespace();
    }

    /**
     * Returns both variant of the file. i.e. file within the template directory as a string
     * and just a path to the file without the directory string concat.
     */
    private function getFile(int $ext): array
    {
        $fullPath = "{$this->templateDir()}/{$this->fileDirectoryFromNamespace()}/{$this->controllerLowercase()}/{$this->getFileName()}{$this->getFileExt($ext)}";
        $filePath = "{$this->fileDirectoryFromNamespace()}/{$this->controllerLowercase()}/{$this->getFileName()}{$this->getFileExt($ext)}";
        return [
            $fullPath,
            $filePath
        ];
    }

    /**
     * Purpose of this method is to attempt to build the twig template file based on the
     * name of the method. For consistency all methods should follow the framework practice
     * all method should have the Action suffix. Although the method wouldn't be considered a
     * action method without the Action suffix
     * @throws Exception
     */
    public function render(?string $filename = null, int $extension = 0): self
    {
        if ($filename !== null) {
            $this->fileToRender = $filename;
        } else {
            list($fullPath, $filePath) = $this->getFile($extension);
            if (!file_exists($fullPath)) {
                throw new Exception(
                    $filePath ." template file could be located within {$this->templateDir()}"
                );
            }
            $this->fileToRender = $filePath;
        }
        return $this;
    }

    /**
     * Set the context. We are binding the current object using the 'this' key property
     * this allows us to access the current object from any .html.twig template. or any
     * template which uses these chainable methods
     */
    public function with(array $context = []): self
    {
        try {
            $this->context = array_merge(['this' => $this->controller], $context);
            return $this;
        } catch(Exception $e) {
            //echo 'Message: ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine();
        }
    }

    /**
     * If the render action contains a form we can chain the form to the with method
     * and will merge all the array context together to create the superContext for
     * our twig template. All forms will array key of 'form' as defined to keep things
     * consistent
     */
    public function form(Object $formRendering, ?string $formAction = null, $data = null): self
    {
        $this->superContext = array_merge(
            $this->context,
            [
                'form' => $formRendering->createForm(
                    ($formAction !== null) ? $formAction : $this->domainRoute(),
                    ($data !== null) ? $data : $this->findSomeData(),
                    $this->controller
                ),
            ],
        );
        return $this;

    }

    /**
     * Return the object for any edit route from any controller which has a findOr404
     * method else will just return null and that's if we are not passing a third
     * argument to our $this->form() method above.
     */
    private function findSomeData(): ?object
    {
        if (method_exists($this->controller, 'findOr404')) {
            if (!empty($this->controller->thisRouteID())) {
                return $this->controller->findOr404();
            } else {
                return NULL;
            }
        }
        return null;
    }

    /**
     * Return the auto generated table data or use the first argument to construct
     * a customized table data array. Second arguments allow you to configure the table
     * attributes
     */
    public function table(array $tableParams = [], ?object $column = null, ?object $repository = null, array $tableData = []): self
    {
        $table = $this->tableData
            ->create(
                ($column !== null) ? $column : $this->controller->column,
                ($repository !== null) ? $repository : $this->tableRepository,
                $this->args,
                $this->controller->repository->getColumns($this->schema),
                $this->controller,
                $this->controller->request
            )
            ->setAttr($tableParams)
            ->table();

        if ($this->tableData) {
            $tableContext = [
                'query_time' => $this->queryTime,
                'table' => $table,
                'pagination' => $this->controller->tableGrid->pagination(),
                'columns' => $this->controller->tableGrid->getColumns(),
                'dataColumns' => $this->controller->tableGrid->getDataColumns(),
                'total_records' => $this->controller->tableGrid->totalRecords(),
                'search_query' => $this->controller->request->handler()->query->getAlnum($this->args['filter_alias'])
            ];
        }
        $this->superContext = array_merge($this->context, (!empty($tableData)) ? $tableData : $tableContext);
        return $this;

    }

    function array_flatten($array) {
        foreach ($array as $arr) {
            return $arr;
        }
    }

    /**
     * Singular can be used to display information about single object. Method
     * which chains the singular() method would be able to access the data
     * using the variable (row) within the rendered twig template.
     */
    public function singular(): self
    {
        $this->superContext = array_merge(
            $this->context,
            ['row' => $this->controller->toArray($this->controller->findOr404())],
        );
        return $this;
    }

    public function binLists(array $selectors = []): self
    {
        if (isset($this->controller->repository)) {
            $lists = $this->controller->repository->getRepo()->findBy($selectors, ['deleted_at' => 1, 'status' => 'trash']);
            $this->superContext = array_merge(
                $this->context,
                ['lists' => $lists]
            );
        }
        return $this;
    }

    /**
     * The end method which finally renders the BaseController render method and
     * pass the populated arguments based on the method chaining
     */
    public function end(?string $type = null): void
    {
        $context = (isset($this->superContext) && count($this->superContext) > 0) ? $this->superContext : $this->context;
        $this->controller->view($this->fileToRender, $context);
    }

    public function endWithApiEndpoint()
    {
        $this->isRestFul = true;
        $context = (isset($this->superContext) && count($this->superContext) > 0) ? $this->superContext : $this->context;
        if (is_bool($this->domainAction) && $this->domainAction === true) {
            echo $this->controller->apiResponse->response(['data' => $context]);
        }

    }

    public function endAfterExecution(): string
    {
        return '';
    }

    /**
     * Checks whether the queried route has a valid id token
     */
    public function hasRouteWithID(): bool
    {
        if (!empty($this->controller->thisRouteID())) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether the current route matches the queried object route
     */
    private function isRouteIDEqual(): bool
    {
        if ($this->controller->thisRouteID() === $this->controller->findOr404()->id) {
            return true;
        }
        return false;
    }

    /**
     * Construct the action routes. returns the relevant strings based on
     * first argument being present.
     */
    private function idRoute(?int $id = null, ?string $ds = null): string
    {
        $out = '';
        $out .= (!empty($this->controller->thisRouteNamespace()) ? $ds : '');
        $out .= $this->getNamespace() . $ds;
        $out .= $this->controllerLowercase() . $ds;
        $out .= ($id !== null) ? $id . $ds : '';
        $out .= $this->getFileName();

        return $out;
    }

    /**
     * Dynamically construct the action routes
     */
    public function domainRoute(string $ds = '/'): string
    {
        $route = '';
        if ($this->controller->thisRouteAction() === $this->getFileName()) {
            if ($this->hasRouteWithID()) {
                if ($this->isRouteIDEqual()) {
                    $route = $this->idRoute($this->controller->thisRouteID(), $ds);
                }
            } else {
                $route = $this->idRoute(null, $ds);
            }
        } else {
            $route = $this->idRoute($this->controller->findOr404()->id, $ds);
        }
        return $route;
    }

    /**
     * Allow passing an array of rules within the rule argument within the execute() method. These
     * rule can ensure certain actions are met before performing other actions.
     * for example ensuring a user enters their password before updating their account on the frontend
     */
    public function enforceRules(array $rules = [], ?object $controller = null): bool
    {
        if (sizeof($rules) > 0) {
            foreach ($rules as $rule) {
                if (isset($rule)) {
                    if (!is_string($rule))
                        throw new BaseInvalidArgumentException('Rules should be defined as strings');
                    if (!in_array($rule, $this->allowedRules, true))
                        throw new BaseOutOfBoundsException('Invalid "' . $rule . '" is not allowed.');
                    return array_walk(
                        $rules,
                        function ($callbackValue, $callbackKey, $controller) {
                            if ($callbackValue) {
                                $validCallback = (new Stringify())->camelCase($callbackValue);
                                if (!method_exists(new DomainLogicRules, $validCallback)) {
                                    throw new BaseBadMethodCallException(
                                        $validCallback . '() does not exists within ' . __CLASS__
                                    );
                                }
                                call_user_func_array(
                                    array(new DomainLogicRules, $validCallback),
                                    [
                                        $callbackValue,
                                        $callbackKey,
                                        $controller
                                    ]
                                );
                            }
                        },
                        $controller
                    );
                }
            }
        }
        return false;
    }

    public function api(): void
    {
        $this->isRestFul = true;
        if (is_bool($this->domainAction) && $this->domainAction === true) {
            echo $this->controller->apiResponse->response(['success' => 'Created Successfully.'], 201);
        } else {
            echo $this->controller->apiResponse->response(['success' => 'The request was unsuccessful'], 201);
        }
    }

    public function getSubmitValue(): string
    {
        return $this->getFileName() . '-' . strtolower($this->controller->thisRouteController());
    }

    public function isSet(string $key, array $array)
    {
        return array_key_exists($key, $array) ? $array[$key] : '';
    }

    public function getControllerArgs(object $controller): array
    {
        $cs = $controller->controllerSettings->getRepo()->findOneBy(['controller_name' => $controller->thisRouteController()]);
        $a = [];
        foreach ($cs as $arg) {
            $a = $arg;
        }
        if (is_array($a) && empty($a)) {
//            $arg = Yaml::file('controller')[$controller->thisRouteController()];
            $arg = Yaml::file('controller')[$controller->thisRouteController()];
        }

        return [
            'records_per_page' => $this->isSet('records_per_page', $a) ? $this->isSet('records_per_page', $a): $arg['records_per_page'],
            'query' => $this->isSet('query', $a) ? $this->isSet('query', $a) : $arg['query'],
            'filter_by' => $this->isSet('filter', $a) ? unserialize($this->isSet('filter', $a)) : $arg['filter_by'],
            'filter_alias' => $this->isSet('alias', $a) ? $this->isSet('alias', $a) : $arg['filter_alias'],
            'sort_columns' => $this->isSet('sortable', $a) ? unserialize($this->isSet('sortable', $a)) : $arg['sort_columns'],
            'additional_conditions' => $this->isSet('additional_conditions', $arg) ? $arg['additional_conditions'] : [],
            'selectors' => $this->isSet('selectors', $arg) ? $arg['selectors'] : [],
        ];

    }

    public function setAccess(object $controller, string $permission): self
    {
        $privilege = PrivilegedUser::getUser();
        $this->privilege = $privilege;
        if (!$privilege->hasPrivilege($permission . '_' . $controller->thisRouteController())){
            $controller->flashMessage('Access Denied!', $controller->flashWarning());
            $controller->redirect('/admin/accessDenied/index');
        }
        return $this;
    }

    public function setOwnerAccess(object $controller)
    {
        $privilege = PrivilegedUser::getUser();
        $userSessionID = (int)$controller->getSession()->get('user_id');
        if ($userSessionID === 1) {
            $routeID = (int)$controller->thisRouteID() !==null ? $controller->thisRouteID() : null;
            if ($userSessionID === $routeID && $privilege->hasPrivilege(ACCESS::CAN_EDIT_OWN_ACCOUNT)) {
                return $this;
            } else {
                /* Might not be doing anything */
                $this->setAccess($controller, ACCESS::CAN_EDIT_OWN_ACCOUNT);
            }

        }
        return $this;
    }

    /**
     * @param object $controller
     * @param string $eventDispatcher
     * @param string $method
     * @param array $context
     * @param array $additionalContext
     * @return void
     */
    public function dispatchSingleActionEvent(object $controller, string $eventDispatcher, string $method, array $context = [], array $additionalContext = []): void
    {
        if ($controller->eventDispatcher) {
            $controller->eventDispatcher->dispatch(
                new $eventDispatcher(
                    $method,
                    array(
                        $context,
                        $additionalContext ? $additionalContext : []
                    ),
                    $controller
                ),
                $eventDispatcher::NAME
            );
        }

    }

    public function isAjaxOrNormal()
    {
        return ($this->isRestFul === true) ?
            $this->controller->formBuilder->getJson() :
            $this->controller->formBuilder->getData();
    }

    /**
     * Return the array argument if the value is indeed an array and the it has atleast 1 element
     * for iteration.|false
     */
    public function isArrayGood(array $array, int $count = 0): array|false
    {
        if (is_array($array) && count($array) > $count) {
            return $array;
        }
        return false;
    }

    public function removeCsrfTokens(array $data, string $field): void
    {
        if ($data) {
            unset($data['_CSRF_INDEX'], $data['_CSRF_TOKEN'], $data['settings-user']);
            unset($data[$this->getSubmitValue()]);
        }

    }

    /**
     * Clear a directory of its files
     * @param string $directory
     */
    public function clear(string $directory): void
    {
        foreach (scandir($directory) as $oldCacheFiles) {
            if ($oldCacheFiles == '.' || $oldCacheFiles == '..')
                continue;
            unlink($directory . '/' .$oldCacheFiles);
        }

    }

    /**
     * Returns a modified clone array modifying the selected elements within the item object
     * which was return by concatinating the a clone string to create a clone but unique item
     * which will be re-inserted within the database.
     *
     * @param string $value
     * @return string
     */
    private function resolvedCloning(string $value): string
    {
        $suffix = '-clone';
        if (str_contains($value, '@')) { /* check if the argument contains an @ symbol */
            $ex = explode('@', $value); /* explode the argument by the @ symbol */
            if (is_array($ex)) {
                /* safely get the first and last index of the array */
                return $ex[array_key_first($ex)] . $suffix . '-' . $ex[array_key_last($ex)];
            }
        } else {
            return $value . $suffix;
        }
    }

    public function flattenArray(array $context): array
    {
        if (is_array($context)) {
            foreach ($context as $con) {
                return $con;
            }
        }
    }

}
