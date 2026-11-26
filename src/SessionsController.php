<?php

namespace LaveroAdmin\Admin\Sessions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaveroAdmin\Admin\Facades\Admin;
use LaveroAdmin\Admin\Layout\Content;

class SessionsController extends Controller
{
    public function index(): Content
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('lavero-admin-sessions::sessions.title'));
            $content->description(trans('lavero-admin-sessions::sessions.description'));

            $driver = config('session.driver');
            $sessions = [];
            $table = config('session.table', 'sessions');

            if ($driver === 'database' && Schema::hasTable($table)) {
                $sessions = DB::table($table)
                    ->orderByDesc('last_activity')
                    ->limit(100)
                    ->get();
            }

            $content->body(view('lavero-admin-sessions::index', [
                'driver'           => $driver,
                'sessions'         => $sessions,
                'currentSessionId' => session()->getId(),
            ])->render());
        });
    }

    public function revoke(Request $request): RedirectResponse
    {
        $id = (string) $request->input('id');
        $table = config('session.table', 'sessions');

        if ($id !== '' && config('session.driver') === 'database' && Schema::hasTable($table)) {
            DB::table($table)->where('id', $id)->delete();
            admin_toastr(trans('lavero-admin-sessions::sessions.revoked'), 'success');
        }

        return back();
    }
}
