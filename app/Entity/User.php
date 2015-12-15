<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $fillable = [
    	'user_name',
    	'email',
    	'password',
    	'level_id',
    	'user_join',
    	'user_pict'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product() {
        return $this->hasMany('App\Entity\Product');
    }
}
