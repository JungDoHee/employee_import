<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee_info_file extends Model
{
    protected $table = 'employee_info_file';
    protected $fillable = [
        'file_path',
    ];
}
