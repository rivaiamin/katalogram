<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
    	'parent_id',
    	'name',
    	'desc',
    	'icon',
    	'image',
    	'type',
    	'color',
    	
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategory() {
        return $this->hasMany('App\Category', 'parent');
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function parent() {
        return $this->belongsTo('App\Category', 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function product() {
        return $this->hasMany('App\Product');
    }

	public function productInc($id) {
		$this->where('id', $id)->increment('product_count', 1);
	}

	public function productDec($id) {
		$this->where('id', $id)->decrement('product_count', 1);
	}
}
