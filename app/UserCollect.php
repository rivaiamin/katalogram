<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCollect extends Model
{
    protected $table = 'user_collects';

    protected $fillable = [
        'product_id',
        'user_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

	public function getUser() {
		return $this->user()->select(['id','name','picture']);
	}

}
