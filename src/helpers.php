<?php

if (! function_exists('setting')) {
    /**
     * @return \Depiedra\LaravelSettings\SettingsManager|\Depiedra\LaravelSettings\Stores\SettingStore|mixed
     */
    function setting()
    {
        $arguments = func_get_args();

        $setting = app('laravel-settings');

        if (! count($arguments)) {
            return $setting;
        }

        if (is_array($arguments[0])) {
            $setting->set($arguments[0]);
        } elseif (! is_null($arguments[0])) {
            return $setting->get(...$arguments);
        }

        return $setting;
    }
}