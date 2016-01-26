<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackRespond extends Model
{
    //
    
    protected $table = 'feedback_respond';
    
    protected $fillable = [
        'feedback_id',
        'user_id',
        'respond_date',
        'respond_type'
    ];
    
    public function feedback(){
        return $this->belongsTo('App\Feedback');
    }
    
    public function user(){
        return $this->hasMany('App\User');
    }
}
