<?php

namespace LaveroAdmin\Admin\Sessions;

use LaveroAdmin\Admin\Controllers\AdminController;
use LaveroAdmin\Admin\Grid;
use LaveroAdmin\Admin\Show;

class LoginLogController extends AdminController
{
    protected function title()
    {
        return trans('lavero-admin-sessions::sessions.history');
    }

    protected function grid(): Grid
    {
        $grid = new Grid(new AdminLoginLog());
        $grid->model()->orderBy('id', 'desc');
        $grid->disableCreateButton();
        $grid->actions(fn ($a) => $a->disableEdit());

        $grid->column('id', __('admin.id'))->sortable();
        $grid->column('username', trans('admin.username'));
        $grid->column('ip', 'IP');
        $grid->column('event', 'Event')->label(['login' => 'success', 'logout' => 'secondary', 'failed' => 'danger']);
        $grid->column('created_at')->sortable();

        return $grid;
    }

    protected function detail($id): Show
    {
        $show = new Show(AdminLoginLog::findOrFail($id));
        $show->field('id');
        $show->field('user_id');
        $show->field('username');
        $show->field('ip');
        $show->field('user_agent');
        $show->field('event');
        $show->field('created_at');
        return $show;
    }
}
