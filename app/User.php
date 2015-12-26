<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = [
    	'name',
    	'email',
    	'password',
    	'level_id',
    	'user_join',
    	'user_pict'
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
    public function product() {
        return $this->hasMany('App\Product');
    }

    public function level() {
        return $this->belongsTo('App\UserLevel');
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = UserLevel::where('level_name', $role)->first();
        }
 
        return $this->level()->attach($role);
    }
     
    public function revokeRole($role)
    {
        if (is_string($role)) {
            $role = UserLevel::where('level_name', $role)->first();
        }
 
        return $this->level()->detach($role);
    }

    public function hasRole($name)
    {
        foreach($this->level as $role)
        {
            if ($role->level_name === $name) return true;
        }
         
        return false;
    }

    public function adminRole($name)
    {

        if ($name == 2) return true;
        
         
        return false;
    }
}
