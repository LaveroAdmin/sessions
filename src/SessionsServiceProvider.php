<?php

namespace LaveroAdmin\Admin\Sessions;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SessionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lavero-admin-sessions');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'lavero-admin-sessions');
        Sessions::boot();

        $record = static function (string $eventName, $user = null, ?string $username = null): void {
            try {
                $model = new AdminLoginLog();
                if (!Schema::connection($model->getConnectionName())->hasTable('admin_login_logs')) {
                    return;
                }
                AdminLoginLog::create([
                    'user_id'    => $user?->id,
                    'username'   => $username ?? ($user?->username ?? $user?->email ?? null),
                    'ip'         => request()?->ip(),
                    'user_agent' => request()?->userAgent(),
                    'event'      => $eventName,
                ]);
            } catch (\Throwable) {
            }
        };

        Event::listen(Login::class, fn (Login $e) => $record('login', $e->user));
        Event::listen(Logout::class, fn (Logout $e) => $record('logout', $e->user));
        Event::listen(Failed::class, fn (Failed $e) => $record('failed', $e->user, (string) ($e->credentials['username'] ?? $e->credentials['email'] ?? '')));
    }
}
