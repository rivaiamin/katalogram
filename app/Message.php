<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    
    protected $table = 'message';
    
    protected $fillable =[
        'message_parent',
        'message_sender',
        'message_recipient',
        'message_content',
        'message_time',
        'message_read'  
    ];
    
    public function subMessage(){
        return $this->hasMany('App\Message', 'message_parent');
    }
    
    public function parent(){
        return $this->belongsTo('App\Message','message_parent');
    }
}
