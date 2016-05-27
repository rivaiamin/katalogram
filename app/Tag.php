<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	use SoftDeletes;
    protected $table = 'tags';

    protected $fillable = [
    	'name'
    ];

    public function product_tag() {
    	return $this->hasMany('App\ProductTag');
    }
}
