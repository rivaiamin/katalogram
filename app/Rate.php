<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'product_rate';

    protected $fillable = [
    	'user_id',
    	'criteria_id',
    	'rate_value'
    ];

    public function user() {
    	return $this->belongsTo('App\Entity\User');
    }

    public function criteria() {
    	return $this->belongsTo('App\Entity\Criteria');
    }
}