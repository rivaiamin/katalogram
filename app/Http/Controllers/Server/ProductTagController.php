<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController;
use App\ProductTag;
use App\Tag;

class ProductTagController extends Controller {
    public function index() {
        //
    }

    public function add(Request $request, ProductController $product, $productId) {
        if ($product->isOwner($productId)) {
            //$input['tag_id'] = $request->input('id');
            $input['product_id'] = $productId;
			$input['name'] = $request->input('name');
			$tag = Tag::where('name', $input['name'])->first();

			if (!$tag) {
				$add = Tag::create(['name'=>$input['name']]);
				if ($add) {
					$input['tag_id'] = $add->id;
				}
			} else $input['tag_id'] = $tag->id;

			$productTag = ProductTag::create($input);

			if($productTag) {
				$params = [
					'status' => "success",
					'message' => "tag telah ditambahkan",
				];
				if (isset($tag)) $params['tag'] = $tag;
			} else {
				$params = [
					'status' => "error",
					'message' => "tag gagal ditambahkan",
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

    public function remove(ProductController $product, $productId, $name) {
		$tag = Tag::where('name', $name)->first();

        if ($product->isOwner($productId)) {
            $remove = ProductTag::where('product_id', $productId)->where('tag_id', $tag->id)->delete();
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
