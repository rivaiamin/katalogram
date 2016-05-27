<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    //
    use SoftDeletes;

    protected $table = 'criterias';

	protected $fillable = [
		'name'
	];

	public function product() {
		return $this->hasMany('App\ProductCriteria');
	}
}
