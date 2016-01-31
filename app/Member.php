<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    
    protected $table = 'member';
    
    protected $fillable = [
        'user_id',
        'member_name',
        'member_born',
        'member_gender',
        'member_summary',
        'member_profile',
        'member_website',
        'member_type',
        'member_category'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function memberContact(){
        return $this->hasMany('App\MemberContact');
    }
}
