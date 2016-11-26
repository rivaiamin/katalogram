<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Rate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class RateController extends Controller
{

    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth');
    }

    public function giveRate(Request $request, $productId) {
        $input = [
            'user_id'       => Auth::user()->id,
            'criteria_id'   => $request->input('criteria_id'),
            'rate_value'    => $request->input('rate_value')
        ];

        $rate = Rate::create($input);

        if($rate){
            $params = [
                'status' => "success",
                'message' => "terima kasih telah memberikan rating",
            ];
        } else {
            $params = [
                'status' => "error",
                'message' => "maaf anda gagal memberikan rating",
            ];
        }

        return json_encode($params);


    }
}
