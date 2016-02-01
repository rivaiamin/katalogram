<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCollect extends Model
{
    //
    
    protected $table = 'member_collect';
    
    protected $fillable = [
        'product_id',
        'user_id'
    ];
    
    public function product(){
        return $this->belongsTo('App\Product', 'product_id');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    
}
