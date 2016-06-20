<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController;
use App\ProductCriteria;

class ProductCriteriaController extends Controller
{
    public function index() {
        //
    }

    public function add(Request $request, ProductController $product, $productId) {
        if ($product->isOwner($productId)) {
            $input['criteria_id'] = $request->input('id');
            $input['product_id'] = $productId;

            $criteria = ProductCriteria::create($input);

            if($criteria){
                $params = [
                    'status' => "success",
                    'message' => "kriteria telah ditambahkan",
                ];
            }
            else {
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

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function remove(ProductController $product, $productId, $id) {
        if ($product->isOwner($productId)) {
            $remove = ProductCriteria::where('product_id', $productId)->where('criteria_id', $id)->delete();
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
