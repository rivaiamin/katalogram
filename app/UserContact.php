<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    //

    protected $table = 'user_contacts';

    protected $fillable = [
        'user_id',
        'contact_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function contact(){
        return $this->belongsTo('App\User');
    }
}
