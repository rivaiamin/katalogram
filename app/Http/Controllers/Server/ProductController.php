<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function index($id){
    	$data['product'] = Product::with(['owner','category'])->where('id', $id)->get();

    	return json_encode($data);
    }
}
