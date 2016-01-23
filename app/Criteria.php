<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    //
    
    protected $table = 'criteria';
    
    protected $fillable = [
        'id',
        'product_id',
        'criteria_name'
    ];
    
    public function product(){
        return $this->hasMany('App\Product');
    }
    
}
