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

namespace Evo\Base\Traits;

use Evo\System\Config;;
use Evo\Utility\Sanitizer;
use Evo\Utility\Yaml;

trait TableSettingsTrait
{

    private function channel(string $controller): string
    {
        return $controller . '_settings';
    }

    private function channelKey(): string
    {
        return "id";
    }

    /**
     * Undocumented function
     */
    private function tableOptions(string $autoController): array
    {
        $config = Config::CONTROLLER[$autoController];
        $cleanData = Sanitizer::clean($_POST);
        //$cleanData = $_POST;

        /* records per page */
        $recordsPerPage = ($cleanData['records_per_page'] ?? $config['records_per_page']);
        /* column visibility */
        $columnVisible = ($cleanData['columns_visible'] ?? []);
        /* filter by */
        $filterBy = ($cleanData['filter_by'] ?? $config['filter_by']);

        return [
            $recordsPerPage,
            $columnVisible,
            $filterBy
        ];
    }

    private function tableData(string $controller): array
    {
        list(
            $recordsPerPage,
            $columnVisible,
            $filterBy
        ) = $this->tableOptions($controller);

        return [
            "id" => $controller,
            "records_per_page" => $recordsPerPage,
            "columns_visible" => $columnVisible,
            "filter_by" => $filterBy
        ];
    }

    /**
     * Allows each entity to be able to be customizable in terms of settings the amount
     * of table data to be displayed per page and change the search filter. These options
     * can be customized from each entity page.
     */
    public function tableSettingsInit(string $controller): bool
    {
        if ($this->isControllerValid($controller)) {
            $fileData = $this->tableData($controller);
            $this->flatDb
                ->flatDatabase()
                ->insert()
                ->in($this->channel($controller))
                ->set($fileData)
                ->execute();
            return true;
        }
        return false;
    }

    /**
     * Method which updates the entity page settings
     */
    public function tableSettingsUpdateInit(string $controller): bool
    {
        if ($this->isControllerValid($controller)) {
            $fileData = $this->tableData($controller);
            $this->flatDb
                ->flatDatabase()
                ->update()
                ->in($this->channel($controller))
                ->set($fileData)
                ->execute();
            return true;
        }
        return false;
    }

    public function tableSettings(string $controller, string $settingName)
    {
        $settings = $this->flatDb
            ->flatDatabase()
            ->read()
            ->in($controller . "_settings")
            ->where("id", "==", $controller)
            ->get();
        $option = [];
        if ($settings) {
            foreach ($settings as $setting) {
                $option[] = $setting;
            }
            return ($option[$settingName] ?? Config::CONTROLLER[$controller][$settingName]);
        }
        return false;
    }
}
