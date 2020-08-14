<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $table='permissions';
    protected $fillable = ['name','description','creator_id'];
}