<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';

    protected $fillable = [
    	'product_id',
    	'tag_id'
    ];

    public function tag() {
    	return $this->belongsTo('App\Entity\Tag');
    }

    public function product() {
    	return $this->belongsTo('App\Entity\Product');
    }
}
