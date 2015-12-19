<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
    	'category_parent',
    	'category_name',
    	'category_desc',
    	'category_icon',
    	'category_type',
    	'category_color'
    	
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategory()
    {
        return $this->hasMany('App\Entity\Category', 'category_parent');
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function parent()
    {
        return $this->belongsTo('App\Entity\Category', 'category_parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product() {
        return $this->hasMany('App\Entity\Product');
    }
}
