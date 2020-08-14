<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    //
    protected $table='invitations';
    protected $fillable = ['sender_id','receiver_id','group_id','hash','status'];
}
