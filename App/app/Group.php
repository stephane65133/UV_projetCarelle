<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table='groups';
    protected $fillable = ['name','creator_id','description','is_active','avatar'];
    public function users() {
    	return $this->belongsToMany('App\User', 'user_groups', 'group_id', 'user_id');
    }
}
