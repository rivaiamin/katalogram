<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
    	'category_id',
    	'user_id',
    	'product_code',
    	'product_name',
    	'product_logo',
    	'product_quote',
    	'product_desc',
    	'product_data',
    	'product_website',
    	'product_release',
    	'product_view',
    	'product_embed',
        'deleted_at'
    ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */

    public function tag() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function preview() {
        return $this->hasMany('App\Preview');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function feedback() {
        return $this->hasMany('App\Feedback');
    }

    public function feedbackPlus(){
        return $this->feedback()
            ->where('feedback_type', 'P');
    }

    public function feedbackMinus(){
        return $this->feedback()
            ->where('feedback_type', 'N');
    }

    public function productList() {
        return $this->select(DB::raw("product.id, product.product_name, product.product_logo, product.product_quote, product.category_id,
                users.name, users.user_pict, 
                category.category_icon,
                count(distinct(member_collect.id)) as num_collect,            
                count(case product_feedback.feedback_type when 'P' then 1 else null end) as num_plus,
                count(case product_feedback.feedback_type when 'N' then 1 else null end) as num_minus,
                avg_rate.rate"
            ))
            ->join('users','product.user_id','=','users.id')
            ->join('category','product.category_id','=','category.id')
            ->leftJoin('product_feedback','product.id','=','product_feedback.product_id')
            ->leftJoin(DB::raw("(".$this->productRate().") avg_rate") ,'avg_rate.product_id','=','product.id')
            ->leftJoin('member_collect','product.id','=','member_collect.product_id')
            ->where('product.product_release', '1')
            ->where('product.deleted_at', NULL)
            ->groupBy('product.id')
            ->orderBy('product.id', 'desc');
    }

    public function numPlus(){
        return $this->feedbackPlus()
            ->selectRaw('product_id, count(*) AS numPlus')
            ->groupBy('product_id');
        //return $this->feedbackPlus()->count();
    }

    public function numMinus(){
        return $this->feedbackMinus()
            ->selectRaw('product_id, count(*) AS numMinus')
            ->groupBy('product_id');
    }

    public function criteria() {
        return $this->hasMany('App\Criteria');
    }

    public function productRate() {
        return "select product_id, ifnull(avg(avg_crit),0) as rate from (SELECT b.product_id, ifnull(avg(a.rate_value), 0) as avg_crit 
                FROM criteria b  LEFT JOIN product_rate a ON a.criteria_id = b.id GROUP BY b.id) criteria_rate";
    }

    public function criteriaRate(){
        //return $this->criteria('criteria_name');
        return $this->criteria();
            //->selectRaw('criteria.id, product_rate.rate_value')
            //->selectRaw('criteria.id, avg(product_rate.rate_value) AS criteria_rate')
            //->join('product_rate','criteria.id','=','product_rate.criteria_id');
            //->groupBy('criteria.id'); 
    }

    public function criteriaCount() {
        return $this->criteria()
            ->selectRaw('product_id, count(*) AS criteriaTotal')
            ->groupBy('product_id');
    }

    public function rateCriteria() {
        return $this->criteria();
    }

    public function memberCollect(){
        return $this->hasMany('App\MemberCollect');
    }

    public function numCollect(){
        return $this->memberCollect()
            ->selectRaw('product_id, count(*) AS numCollect')
            ->groupBy('product_id');
    }

    /*public function avgCount() {
        return $this->criteria()
        ->selectRaw('criteria_id, count(*) AS aggregate')
        ->groupBy('criteria_id');
    }*/


}
