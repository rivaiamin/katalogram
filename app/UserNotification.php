<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable =[
        'user_id',
        'content',
        'link',
		'is_read'
    ];

    public function user(){
        return $this->hasMany('App\User');
    }
}
