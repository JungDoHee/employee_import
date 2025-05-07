<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employeeInfo extends Model
{
    protected $table = 'employee_info';
    public $timestamps = false;
    protected $dateFormat = 'U';

    protected $guarded = [];
}
