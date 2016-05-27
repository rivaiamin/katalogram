<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
 
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    protected $table = 'users';

    protected $fillable = [
    	'name',
    	'email',
    	'password',
    	'join',
    	'facebook',
		'google'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userProfile() {
        return $this->hasOne('App\UserProfile');
    }
    
    public function product() {
        return $this->hasMany('App\Product');
    }

	public function userContact() {
        return $this->hasMany('App\UserContact');
    }

	public function userCollect() {
        return $this->hasMany('App\UserCollect');
    }

	public function userLink() {
        return $this->hasMany('App\UserLink');
    }

	public function userMessage() {
        return $this->hasMany('App\UserMessage');
    }

	public function userNotification() {
        return $this->hasMany('App\UserNotification');
    }

	public function productFeedback() {
		return $this->hasMany('App\ProductFeedback');
	}

    /*public function level() {
        return $this->belongsTo('App\UserLevel');
    }
*/
    /*public function assignRole($role)
    {
        if (is_string($role)) {
            $role = UserLevel::where('level_name', $role)->first();
        }
 
        return $this->level()->attach($role);
    }
     */
  /*  public function revokeRole($role)
    {
        if (is_string($role)) {
            $role = UserLevel::where('level_name', $role)->first();
        }
 
        return $this->level()->detach($role);
    }*/

    /*public function hasRole($name)
    {
        foreach($this->level as $role)
        {
            if ($role->level_name === $name) return true;
        }
         
        return false;
    }
*/
    /*public function adminRole($name)
    {

        if ($name == 2) return true;
        
         
        return false;
    }
*/

}
