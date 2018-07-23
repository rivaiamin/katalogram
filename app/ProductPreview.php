<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPreview extends Model
{
    protected $table = 'product_previews';

    protected $fillable = [
    	'product_id',
    	'image',
    	'caption'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

}
