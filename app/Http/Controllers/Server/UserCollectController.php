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

    public function add(Request $request) {
        $input = [
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::user()->id
        ];
        $collect = UserCollect::create($input);

        if($collect){
			$product = Product::where('id',$input['product_id']);
			$product->increment('collect_count');
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

    public function remove($id) {
        $collect = UserCollect::find($id)->where('user_id', Auth::user()->id);

	   if ($collect->delete) {
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
