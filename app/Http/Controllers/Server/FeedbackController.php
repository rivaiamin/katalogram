<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Product;
use App\FeedbackRespond;
use App\Feedback;
use App\MemberCollect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

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
        $data['data'] = $input;
        
        return json_encode($data);
    }

    public function respondFeedback($feedbackId, $respondType)
    {
        $input = [
            'user_id'       => Auth::user()->id,
            'feedback_id'   => $feedbackId,
            'respond_date'  => Carbon::now(),
            'respond_type'  => $respondType,
        ];

        // dd($input);

        $rate = FeedbackRespond::create($input);

        if($rate->first()){
            $params = [
                'status' => "success",
                'message' => "terima kasih telah memberikan respon feedback",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "maaf anda gagal memberikan respond feedback",
            ];
        }

        return json_encode($params);
    }

    public function giveCollection($productId)
    {
        $input = [
            'user_id'       => Auth::user()->id,
            'product_id'   => $productId,
        ];

        $cekMember = MemberCollect::where('product_id', $input['product_id'])
                                    ->where('user_id', $input['user_id'])
                                    ->get();
        // dd($cekMember);
        if($cekMember->count() < 1){
            $rate = MemberCollect::create($input);
            $params = [
                'status' => "success",
                'message' => "katalog telah ditambahkan sebagai favorit",
            ];
        }
        else{
            $params = [
                'status' => "error",
                'message' => "maaf anda gagal menambahkan katalog sebagai favorit",
            ];
        }

        return json_encode($params);
    }

    public function setEndorse($feedbackId)
    {
        $feedback = Feedback::where('id', $feedbackId);

        $input = [
            'feedback_endorse'       => 1,
        ];

        // dd($input);

        $feedback->update($input);

        if ($feedback->first()){

            $params = [
                'status' => "success",
                'message' => "Feedback telah dijadikan sebagai endorse",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "Feedback gagal dijadikan sebagai endorse",
            ];
        }
        
        return json_encode($params);
    }
}
