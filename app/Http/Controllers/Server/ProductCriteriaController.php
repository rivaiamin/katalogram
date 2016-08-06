<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController;
use App\ProductCriteria;
use App\Criteria;

class ProductCriteriaController extends Controller
{
	public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index() {
        //
    }

    public function add(Request $request, ProductController $product, $productId) {
        if ($product->isOwner($productId)) {
            //$input['criteria_id'] = $request->input('id');
            $input['product_id'] = $productId;
			$input['name'] = $request->input('name');
			$criteria = Criteria::where('name', $input['name'])->first();

			if (!$criteria) {
				$add = Criteria::create(['name'=>$input['name']]);
				if ($add) {
					$input['criteria_id'] = $add->id;
				}
			} else $input['criteria_id'] = $criteria->id;

            $productCriteria = ProductCriteria::create($input);

            if($productCriteria){
                $params = [
                    'status' => "success",
                    'message' => "kriteria telah ditambahkan",
                ];
				if (isset($criteria)) $params['criteria'] = $criteria;
            } else {
                $params = [
                    'status' => "error",
                    'message' => "kriteria gagal ditambahkan",
                ];
            }
        } else {
            $params = [
                    'status' => "error",
                    'message' => "akses invalid",
                ];
        }
        return response()->json($params, 200);
    }

	public function setRateAvg($id) {
		$product = new ProductController;
		$criteria = ProductCriteria::where('id', $id);
		$rate = $criteria->first()->productCriteriaRate();
		$row = $rate->count();
		$total = $rate->sum('value');
		$input['rate_avg'] = round($total / $row, 2);

		if ($criteria->update($input)) {
			$product->setRateAvg($criteria->first()->product_id);
			return true;
		} else return false;
	}

    public function remove(ProductController $product, $productId, $name) {
        $criteria = Criteria::where('name', $name)->first();

		if ($product->isOwner($productId)) {
            $remove = ProductCriteria::where('product_id', $productId)->where('criteria_id', $criteria->id)->delete();
            if ($remove) {
				$params = [
					'status' => "success",
					'message' => "kriteria telah dihapus",
				];
			} else {
				$params = [
					'status' => "success",
					'message' => "kriteria gagal dihapus",
				];
			}
        } else {
            $params = [
                'status' => "error",
                'message' => "akses invalid",
            ];
		}
        return response()->json($params, 200);
    }
}
