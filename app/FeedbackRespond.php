<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackRespond extends Model
{
    //
    
    protected $table = 'feedback_responds';
    
    protected $fillable = [
        'feedback_id',
        'user_id',
        'type'
    ];
    
    public function feedback(){
        return $this->belongsTo('App\ProductFeedback');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
