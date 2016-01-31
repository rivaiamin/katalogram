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
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function member(){
        return $this->belongsTo('App\Member');
    }
}
