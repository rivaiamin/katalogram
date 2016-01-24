<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PreviewController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function previewUpload(Request $request, $productId)
    {
        $input = $request->all();
        $product = Product::where('id', $productId)->first();

        $create = $product->preview()->create($input);
        // $create = Preview::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "gambar tampilan telah ditambahkan";
        } else {
            $data['status'] = "error";
            $data['message'] = "gambar tampilan gagal ditambahkan";
        }

        return json_encode($data);
    }
}
