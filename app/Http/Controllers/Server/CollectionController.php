<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserCollect;
use Auth;

class CollectionController extends Controller
{

    public function __construct() {
        $this->middleware('jwt.auth');
    }

	public function index()
    {
        //
    }

    public function add($productId)
    {
        $input = [
            'product_id' => $productId,
            'user_id' => Auth::user()->id
        ];
        $collect = UserCollect::create($input);

        if($collect){
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

   public function delete($id)
   {
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
