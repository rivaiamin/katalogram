<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tags';

    protected $fillable = [
    	'product_id',
    	'tag_id'
    ];

	public function product(){
        return $this->belongsTo('App\Product');
    }

	public function tag() {
		return $this->belongsTo('App\Tag');
	}

}
