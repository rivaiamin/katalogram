<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    //
    
    protected $table = 'criteria';
    
    protected $fillable = [
        'product_id',
        'criteria_name'
    ];
    
    public function product(){
        return $this->belongsTo('App\Product');
    }

    /*public function rateCount(){
    	return $this->hasMany('App\Rate')
        ->selectRaw('criteria_id, count(*) AS aggregate')
        ->groupBy('criteria_id');
    }*/
    
}
