<?php

namespace LaveroAdmin\Admin\Sessions;

use Illuminate\Routing\Router;
use LaveroAdmin\Admin\Admin;
use LaveroAdmin\Admin\Extension;

class Sessions extends Extension
{
    public static function boot(): void
    {
        parent::routes(function (Router $router) {
            $router->get('sessions', 'LaveroAdmin\Admin\Sessions\SessionsController@index')->name('sessions.index');
            $router->post('sessions/revoke', 'LaveroAdmin\Admin\Sessions\SessionsController@revoke')->name('sessions.revoke');
            $router->resource('sessions/logs', 'LaveroAdmin\Admin\Sessions\LoginLogController', ['as' => 'sessions']);
        });
        Admin::extend('sessions', __CLASS__);
    }

    public static function import(): void
    {
        parent::createMenu('Sessions & Audit', 'sessions', 'icon-user-shield', 0, [
            ['title' => 'Active Sessions', 'path' => 'sessions', 'uri' => 'sessions', 'icon' => 'icon-desktop'],
            ['title' => 'Login History', 'path' => 'sessions/logs', 'uri' => 'sessions/logs', 'icon' => 'icon-history'],
        ]);
        parent::createPermission('Sessions & Audit', 'ext.sessions', 'sessions*');
    }
}
