<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use SoftDeletes;

    protected $table = 'links';

	protected $fillable = [
		'name'
	];

	public function product() {
		return $this->hasMany('App\ProductLink');
	}

	public function user() {
		return $this->hasMany('App\UserLink');
	}
}
