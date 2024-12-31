<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Task;
use app\Models\User;

class TaskHistory extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'id');
    }
}
