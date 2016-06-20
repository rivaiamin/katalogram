<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Criteria;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController as ProductCtrl;

class CriteriaController extends Controller
{

    public function __construct() {
         $this->middleware('jwt.auth');
    }

	public function index() {
		$data = Criteria::select('id','name')->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

    public function create(ProductCtrl $product, Request $request, $productId) {


    }

    public function delete(ProductCtrl $product, $productId, $criteriaId)
    {

    }

}
