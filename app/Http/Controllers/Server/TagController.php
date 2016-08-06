<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Tag;
use App\Product;
use App\ProductTag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\CatalogController as CatalogCtrl;

class TagController extends Controller
{
    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except'=>['index']] );
    }

	public function index() {
		$data = Tag::select('id','name')->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

    public function add(Request $request) {

    }

    public function delete($id) {
		$tag = Tag::where('tag', $id)->delete();
		$params = [
			'status' => "success",
			'message' => "tag telah dihapus",
		];

        return json_encode($params);
    }
}
