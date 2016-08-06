<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use SoftDeletes;

    protected $table = 'criterias';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	protected $hidden = ['deleted_at'];

	public function product() {
		return $this->hasMany('App\ProductCriteria');
	}
}
