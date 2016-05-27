<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductLink extends Model
{
    protected $table = 'product_links';

    protected $fillable = [
        'product_id',
        'link_id',
		'url'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

	public function link() {
		retrun $this->belongsTo('App\Link');
	}

}
