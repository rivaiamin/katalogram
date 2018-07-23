<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    //

    protected $table = 'user_messages';

    protected $fillable =[
        'sender_id',
        'recipient_id',
        'content',
        'is_read'
    ];

    public function sender(){
        return $this->hasMany('App\User');
    }

    public function recipient(){
        return $this->belongsTo('App\User');
    }
}
