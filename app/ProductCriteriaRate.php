<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCriteriaRate extends Model {
    protected $table = 'product_criteria_rates';

    protected $fillable = [
    	'product_criteria_id',
    	'user_id',
        'value'
    ];

    public function productCriteria() {
        return $this->belongsTo('App\ProductCriteria');
    }

	public function user() {
		return $this->belongsTo('App\User');
	}
}
