<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    
    protected $table = 'member';
    
    protected $fillable = [
        'id',
        'member_name',
        'member_born',
        'member_gender',
        'member_summary',
        'member_profile',
        'member_website',
        'member_type',
        'member_category'
    ];
}
