<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class FeedbackController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function giveFeedback(Request $request, $productId)
    {

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        // dd($input);
        $product = Product::where('id', $productId)->first();

        $create = $product->feedback()->create($input);
        // $create = Preview::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "terima kasih telah memberikan feedback";
        } else {
            $data['status'] = "error";
            $data['message'] = "maaf feedback gagal dikirim";
        }

        return json_encode($data);
    }
}
