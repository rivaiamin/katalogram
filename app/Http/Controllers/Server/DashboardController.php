<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\ProductFeedback;
use App\Criteria;
use App\Tag;

class DashboardController extends Controller {

	public function __construct() {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

	public function index() {
        $data['user_count'] = User::count();
        $data['product_count'] = Product::count();
        $data['feedback_count'] = ProductFeedback::count();
        $data['tag_count'] = Tag::count();
        $data['criteria_count'] = Criteria::count();

		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

}
