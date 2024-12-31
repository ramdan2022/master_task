<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'Title',
        'Descreption',
        'project_id',
        'Status'
    ];
}
