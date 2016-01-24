<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $table = 'product_preview';

    protected $fillable = [
    	'product_id',
    	'preview_pict',
    	'preview_caption'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

}
