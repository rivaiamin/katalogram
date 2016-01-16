<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    protected $fillable = [
    	'tag_name'
    ];

    public function productTag() {
    	return $this->hasMany('App\Entity\ProductTag');
    }
}
