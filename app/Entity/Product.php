<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
    	'category_id',
    	'user_id',
    	'product_code',
    	'product_name',
    	'product_logo',
    	'product_quote',
    	'product_desc',
    	'product_data',
    	'product_website',
    	'product_release',
    	'product_view',
    	'product_embed'
    ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user() {
        return $this->belongsTo('App\Entity\User');
    }

}
