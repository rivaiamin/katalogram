<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    protected $fillable = [
    	'tag_name'
    ];

    public function product() {
    	return $this->belongsToMany('App\Product');
    }
}
