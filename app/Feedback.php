<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'product_feedback';

    protected $fillable = [
    	'user_id',
    	'product_id',
    	'feedback_comment',
    	'feedback_type'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

}
