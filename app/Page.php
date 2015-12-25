<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';

    protected $fillable = [
    	'page_slug',
    	'page_title',
    	'page_content'
    ];
}
