<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function avgScore(){
        //return $this->criteria('criteria_name');
            
    }

    public function criteriaCount() {
        return $this->criteria()
            ->selectRaw('product_id, count(*) AS criteriaTotal')
            ->groupBy('product_id');
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
