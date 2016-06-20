<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'user_contacts';

    protected $fillable = [
        'user_id',
        'contact_id'
    ];

    public function user(){
        return $this->belongsTo('App\User')->select('id','name','picture','product_count','contact_count','connect_count');
    }

    public function contact(){
        return $this->belongsTo('App\User')->select('id','name','picture','product_count','contact_count','connect_count');
    }

	/*public function connect() {
		return $this->belongsTo('App\User','contact_id')->select('id','name','picture');
	}*/
}
