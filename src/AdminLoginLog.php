<?php

namespace LaveroAdmin\Admin\Sessions;

use Illuminate\Database\Eloquent\Model;

class AdminLoginLog extends Model
{
    protected $table = 'admin_login_logs';
    protected $fillable = ['user_id', 'username', 'ip', 'user_agent', 'event'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(config('admin.database.connection') ?: config('database.default'));
    }
}
