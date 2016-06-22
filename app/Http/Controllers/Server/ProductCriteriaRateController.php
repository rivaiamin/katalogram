<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductCriteriaRate;
use App\Http\Controllers\Server\ProductCriteriaController;
use Auth;
use DB;

class ProductCriteriaRateController extends Controller
{
	public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index(){
        //
    }

    public function store(Request $request, ProductCriteriaController $productCriteria) {
        $input = $request->only('product_criteria_id', 'value');
		$input['user_id'] = Auth::user()->id;

		$rate = ProductCriteriaRate::where(['user_id'=>$input['user_id'],'product_criteria_id'=>$input['product_criteria_id']]);

		if (!$rate->first()) {
			$store = ProductCriteriaRate::create($input);
			$message = "terima kasih telah memberikan penilaian";
		} else {
			$store = $rate->update(['value'=>$input['value']]);
			$message = "terima kasih telah memperbarui penilaian";
		}

		if ($store) $data = $productCriteria->setRateAvg($input['product_criteria_id']);

		//dd(DB::getQueryLog());
		return response()->json(['status' => 'success', 'message' => $message, 'data'=>$data], 200);
    }

    public function replace(Request $request, $id) {
        //
    }

}
