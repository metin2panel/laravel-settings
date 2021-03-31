<?php

namespace Depiedra\LaravelSettings;

use Depiedra\LaravelSettings\Stores\DatabaseSettingStore;
use Depiedra\LaravelSettings\Stores\JsonSettingStore;
use Depiedra\LaravelSettings\Stores\MemorySettingStore;
use Illuminate\Support\Manager;

class SettingsManager extends Manager
{
    /**
     * @return mixed|string
     */
    public function getDefaultDriver()
    {
        return $this->getConfig('store');
    }

    /**
     * @return \Depiedra\LaravelSettings\Stores\JsonSettingStore
     */
    public function createJsonDriver()
    {
        $path = $this->getConfig('path');

        return new JsonSettingStore($this->container['files'], $path);
    }

    /**
     * @return \Depiedra\LaravelSettings\Stores\DatabaseSettingStore
     */
    public function createDatabaseDriver()
    {
        $connectionName = $this->getConfig('connection');
        $connection = $this->container['db']->connection($connectionName);
        $table = $this->getConfig('table');
        $keyColumn = $this->getConfig('key_column');
        $valueColumn = $this->getConfig('value_column');

        return new DatabaseSettingStore($connection, $table, $keyColumn, $valueColumn);
    }

    /**
     * @return \Depiedra\LaravelSettings\Stores\MemorySettingStore
     */
    public function createMemoryDriver()
    {
        return new MemorySettingStore();
    }

    /**
     * @return \Depiedra\LaravelSettings\Stores\MemorySettingStore
     */
    public function createArrayDriver()
    {
        return $this->createMemoryDriver();
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    protected function getConfig($key)
    {
        return $this->container['config']->get('laravel-settings.' . $key);
    }
}
