<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCriteria extends Model
{
	use softDeletes;
	protected $table = 'product_criterias';

    protected $fillable = [
        'product_id',
        'criteria_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

	public function criteria() {
		return $this->belongsTo('App\Criteria');
	}

    public function criteriaRate() {
        return $this->hasMany('App\CriteriaRate');
    }

    /*public function avgCriteria() {
        return $this->criteriaRate()
            ->selectRaw('criteria_id, avg(value) AS criteria_rate')
            ->groupBy('criteria_id');
    }

    public function rateCriteria() {
        //TODO: [problem] group by criteriaId make numFeedback get doubled
        return DB::raw("(SELECT b.product_id, b.criteria_name, ifnull(avg(a.rate_value), 0) as avg
                  FROM criteria b
                  LEFT JOIN product_rate a ON a.criteria_id = b.id
                  GROUP BY b.id) rate_criteria");
    }
*/
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
