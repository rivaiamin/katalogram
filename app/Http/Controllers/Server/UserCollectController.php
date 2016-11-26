<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UserCollect;
use App\Product;
use Auth;

class UserCollectController extends Controller
{
	public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index() {
        //
    }

	/*public function isCollect($productId) {
		return Auth::user()->id;
		if () {
			$collect = new UserCollect;
			$collect->where(['user_id'=>Auth::user()->id, 'product_id'=>$id]);
			if ($collect->count() > 0) return true;
			else return false;
		} else return false;
	}*/

    public function add($productId) {
        $input = [
            'product_id' => $productId,
            'user_id' => Auth::user()->id
        ];
        $collect = UserCollect::create($input);

        if($collect){
			$product = Product::where('id', $productId);
			$product->increment('collect_count');
			Auth::user()->increment('collect_count');
            $data = [
                'status' => "success",
                'message' => "produk telah ditambahkan ke koleksi",
            ];
	   		return response()->json($data, 200);
        } else {
            $data = [
                'status' => "error",
                'message' => "produk gagal ditambahkan ke koleksi",
            ];
	   		return response()->json($data, 500);
        }
    }

    public function remove($productId) {
       $collect = UserCollect::where('user_id', Auth::user()->id)
		   ->where('product_id', $productId)->first();

	   if ($collect->delete()) {
		    $product = Product::where('id', $productId);
			$product->decrement('collect_count');
		    Auth::user()->decrement('collect_count');

		   	$data = [
                'status' => "success",
                'message' => "produk telah dihapus dari koleksi",
            ];
	   		return response()->json($data, 200);
	   } else {
		    $data = [
                'status' => "error",
                'message' => "produk gagal dihapus dari koleksi",
            ];
	   		return response()->json($data, 500);
	   }
    }
}
