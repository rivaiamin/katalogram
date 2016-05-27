<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function subCategory()
    {
        return $this->hasMany('App\Category', 'parent');
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function product() {
        return $this->hasMany('App\Product');
    }
}
