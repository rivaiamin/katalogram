<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'category_id',
        'fullname',
        'born',
        'cover',
		'location',
        'summary',
        'profile',
    ];
	//protected $dates = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

	public function picture() {
		return $this->select('picture');
	}

  	/*public function isConnect($userId, $memberId) {
        if ($userId == $memberId) return true;
        else {
            $connect = DB::table('contact')
                ->where('user_id', $userId)
                ->where('id', $memberId);

            if ($connect->first()) return true;
            else return false;
        }
    }*/
}
