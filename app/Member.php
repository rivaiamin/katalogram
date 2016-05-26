<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Member extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'member';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'member_name',
        'member_born',
        'member_gender',
        'member_summary',
        'member_profile',
        'member_website',
        'member_type',
        'member_category'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function memberContact() {
        return $this->hasMany('App\MemberContact');
    }

    public function isConnect($userId, $memberId) {
        if ($userId == $memberId) return true; 
        else {
            $connect = DB::table('member_contact')
                ->where('user_id', $userId)
                ->where('member_id', $memberId);

            if ($connect->first()) return true;
            else return false;
        }
    }
}
