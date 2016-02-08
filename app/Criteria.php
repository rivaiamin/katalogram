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

    public function productRate() {
        return $this->hasMany('App\Rate', 'product_id');
    }

    /*public function avgScore() {
        return $this->productRate()
            ->selectRaw('avg(rate_value) AS avgScore')
            ->groupBy('criteria_id');
    }*/

    /*public function rateCount(){
    	return $this->hasMany('App\Rate')
        ->selectRaw('criteria_id, count(*) AS aggregate')
        ->groupBy('criteria_id');
    }*/
    
}
