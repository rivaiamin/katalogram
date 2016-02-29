<?php

namespace App;

use DB;
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
        return $this->hasMany('App\Rate');
    }

    public function avgCriteria() {
        return $this->productRate()
            ->selectRaw('criteria_id, avg(rate_value) AS criteria_rate')
            ->groupBy('criteria_id');
    }

    public function rateCriteria() {
        //TODO: [problem] group by criteriaId make numFeedback get doubled
        return DB::raw("(SELECT b.product_id, b.criteria_name, ifnull(avg(a.rate_value), 0) as avg 
                  FROM criteria b  
                  LEFT JOIN product_rate a ON a.criteria_id = b.id
                  GROUP BY b.id) rate_criteria");
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
