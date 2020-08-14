<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table='roles';
    protected $fillable = ['name','creator_id','description'];
    public function permissions() {
    	return $this->belongsToMany('App\Permission', 'role_permissions', 'role_id', 'permission_id');
    }
    public function users() {
    	return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }
}
