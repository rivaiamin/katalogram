<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFeedback extends Model
{
    use SoftDeletes;

	protected $table = 'product_feedbacks';

    protected $fillable = [
    	'user_id',
    	'product_id',
        'time',
    	'comment',
        'endorse',
    	'type'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

	public function user() {
		return $this->belongsTo('App\User');
	}

}
