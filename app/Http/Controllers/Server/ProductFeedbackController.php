<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Product;
use App\FeedbackRespond;
use App\ProductFeedback;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

class ProductFeedbackController extends Controller {
    public function __construct() {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

	public function get(ProductFeedback $feedback, $after, $limit) {
		$lists = $feedback->orderBy('id', 'desc')
				 ->take($limit);

		if ($after != 0) $lists->where('id','<', $after);
        $data['feedbacks'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

	public function isOwner($id) {
		$feedback = ProductFeedback::where('id',$id)->first();
        if ($feedback->user_id == Auth::user()->id) return true;
        else return false;
	}

    public function send(Request $request, $productId) {
        $input = $request->only('type','comment');
		$input['time'] = time();
		$input['product_id'] = $productId;
        $input['user_id'] = Auth::user()->id;
        $create = ProductFeedback::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "terima kasih telah memberikan feedback";
        	$data['data'] = $create;
			$product = Product::where('id',$productId);
			if ($input['type'] == 'P') $product->increment('plus_count');
			elseif ($input['type'] == 'M') $product->increment('minus_count');
        } else {
            $data['status'] = "error";
            $data['message'] = "maaf feedback gagal dikirim";
        }

        return response()->json($data, 200);
    }

    public function respondFeedback($feedbackId, $respondType) {
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

    public function setEndorse($feedbackId) {
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

	public function remove($productId, $id) {
		if ($this->isOwner($id) || Auth::user()->hasRole(['manager', 'admin'])) {
			$feedback = ProductFeedback::find($id);

			$product = Product::where('id',$feedback->product_id);
			if ($feedback->type == 'P') $product->decrement('plus_count');
			elseif ($feedback->type == 'M') $product->decrement('minus_count');

			if ($feedback->delete()) {
				$data['status'] = "success";
				$data['message'] = "tanggapan telah dihapus";
			} else {
				$data['status'] = "error";
				$data['message'] = "tanggapan gagal dihapus";
			}
		} else {
			$data['status'] = "error";
			$data['message'] = "akses invalid";
		}

		return response()->json($data, 200);
	}

}
