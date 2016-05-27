<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLink extends Model
{
    protected $table = 'user_links';

    protected $fillable = [
        'user_id',
        'link_id',
		'url'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

	public function link() {
		retrun $this->belongsTo('App\Link');
	}

}
