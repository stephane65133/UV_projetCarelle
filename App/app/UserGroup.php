<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    protected $table='user_groups';
    protected $fillable = ['user_id','group_id','is_admin'];
}
