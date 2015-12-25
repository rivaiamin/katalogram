<?php

namespace App;

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
    public function owner() {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category() {
        return $this->belongsTo('App\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function feedback() {
        return $this->hasMany('App\Feeback');
    }


}
