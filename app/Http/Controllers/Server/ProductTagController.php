<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController;
use App\ProductTag;

class ProductTagController extends Controller
{
    public function index() {
        //
    }

    public function add(Request $request, ProductController $product, $productId) {
        if ($product->isOwner($productId)) {
            $input['tag_id'] = $request->input('id');
            $input['product_id'] = $productId;

            $tag = ProductTag::create($input);

            if($tag){
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function remove(ProductController $product, $productId, $id) {
        if ($product->isOwner($productId)) {
            $remove = ProductTag::where('product_id', $productId)->where('tag_id', $id)->delete();
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
