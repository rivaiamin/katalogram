<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'product';

    protected $fillable = [
    	'user_id',
    	'product_id',
    	'feeback_time',
    	'feeback_comment',
    	'feeback_type'
    ];

    public function product() {
        return $this->belongsTo('App\Entity\Product');
    }

}
