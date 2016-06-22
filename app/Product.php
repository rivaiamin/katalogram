<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;

class Product extends Model {
	use SoftDeletes;

    public $table = 'products';

    protected $fillable = [
    	'category_id',
    	'user_id',
    	'slud',
    	'name',
    	'logo',
    	'picture',
    	'quote',
    	'desc',
    	'data',
    	'embed',
    	'is_release',
    	'embed',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

	public function category() {
        return $this->belongsTo('App\Category');
    }

    public function productTag() {
        return $this->hasMany('App\ProductTag');
    }

	public function productLink() {
        return $this->hasMany('App\ProductLink')->withTimestamps();
    }

    public function productFeedback() {
        return $this->hasMany('App\ProductFeedback')
			->select(DB::raw("product_feedbacks.*, users.name as username, users.picture as userpict"))
			->join('users','product_feedbacks.user_id','=', 'users.id');
    }

    public function feedbackPlus(){
        return $this->productFeedback()
            ->where('type', 'P');
    }

    public function feedbackMinus(){
        return $this->productFeedback()
            ->where('type', 'M');
    }

	public function productCriteria() {
        return $this->hasMany('App\ProductCriteria');
    }

    public function productList() {
		return $this->select(
				DB::raw("products.id, products.name, products.logo, products.quote, products.category_id, users.name as username, users.picture as userpict,
				products.rating_avg, products.plus_count, products.minus_count, products.collect_count"
            ))
            ->join('users','products.user_id','=','users.id')
            ->where('products.is_release', '1')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc');
        /*return $this->select(DB::raw("products.id, products.name, products.logo, products.quote, products.category_id,
                users.name, users.user_pict, 
                category.category_icon,
                count(distinct(member_collect.id)) as num_collect,            
                count(case feedback.feedback_type when 'P' then 1 else null end) as num_plus,
                count(case feedback.feedback_type when 'N' then 1 else null end) as num_minus,
                avg_rate.rate"
            ))
            ->join('users','products.user_id','=','users.id')
            ->join('category','products.category_id','=','category.id')
            ->leftJoin('feedback','products.id','=','feedback.id')
            ->leftJoin(DB::raw("(".$this->productRate().") avg_rate") ,'avg_rate.id','=','products.id')
            ->leftJoin('member_collect','products.id','=','member_collect.id')
            ->where('products.release', '1')
            ->where('products.deleted_at', NULL)
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc');*/

    }

	/*public function isCollect() {
		//DB::table('user_collects')->where(['user_id'=>Auth::user()->id, 'product_id'=>]);
	}*/

    /*public function productRate() {
        return "select id, ifnull(avg(avg_crit),0) as rate from (SELECT b.id, ifnull(avg(a.rate_value), 0) as avg_crit
                FROM criteria b  LEFT JOIN rate a ON a.criteria_id = b.id GROUP BY b.id) criteria_rate";
    }*/



    /*public function numCollect(){
        return $this->memberCollect()
            ->selectRaw('id, count(*) AS numCollect')
            ->groupBy('id');
    }*/

	/*public function preview() {
        return $this->hasMany('App\Preview');
    }*/


    /*public function numPlus(){
        return $this->feedbackPlus()
            ->selectRaw('id, count(*) AS numPlus')
            ->groupBy('id');
        //return $this->feedbackPlus()->count();
    }

    public function numMinus(){
        return $this->feedbackMinus()
            ->selectRaw('id, count(*) AS numMinus')
            ->groupBy('id');
    }*/



    //public function criteriaRate(){
        //return $this->criteria('criteria_name');
        //return $this->criteria();
            //->selectRaw('criteria.id, rate.rate_value')
            //->selectRaw('criteria.id, avg(rate.rate_value) AS criteria_rate')
            //->join('rate','criteria.id','=','rate.criteria_id');
            //->groupBy('criteria.id'); 
    //}

    /*public function criteriaCount() {
        return $this->criteria()
            ->selectRaw('id, count(*) AS criteriaTotal')
            ->groupBy('id');
    }*/

    /*public function rateCriteria() {
        return $this->criteria();
    }*/



    /*public function avgCount() {
        return $this->criteria()
        ->selectRaw('criteria_id, count(*) AS aggregate')
        ->groupBy('criteria_id');
    }*/


}
