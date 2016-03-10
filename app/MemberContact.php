<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberContact extends Model
{
    //
    
    protected $table = 'member_contact';
    
    protected $fillable = [
        'user_id',
        'member_id'
    ];
    
    public function contact(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function connect(){
        return $this->belongsTo('App\User','member_id');
    }
}
