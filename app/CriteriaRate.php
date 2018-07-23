<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaRate extends Model
{
    protected $table = 'criteria_rates';

    protected $fillable = [
    	'user_id',
    	'criteria_id',
    	'value'
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function criteria() {
    	return $this->belongsTo('App\ProductCriteria');
    }
}
