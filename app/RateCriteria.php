<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateCriteria extends Model
{
    protected $table = 'rate_criteria';

    protected $fillable = [
    	'product_id',
    	'criteria_name'
    ];

    public function product() {
    	$return $this->belongsTo('App\Product');
    }
}
