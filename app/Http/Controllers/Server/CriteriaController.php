<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Criteria;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\ProductController as ProductCtrl;

class CriteriaController extends Controller
{

    public function __construct() {
         $this->middleware('jwt.auth');
    }

	public function index() {
		$data = Criteria::select('name')->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

	public function get($after, $limit, Criteria $criteria, Request $request) {
		$name = $request->input('name');

    	$lists = $criteria->orderBy('id', 'desc')
				 ->take($limit);
		if (!empty($name)) $lists->where($school->table.'.name', 'like', "%$name%");
		if ($after != 0) $lists->where('id','<', $after);

        $data['criterias'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
	public function add(Request $request) {
		$input = $request->only(['name']);

		$save = Tag::create($input);

    	if ($save) {
    		$data['status'] = 'success';
    		$data['message'] = 'criteria added';
    		$data['criteria'] = $save;
    	} else {
    		$data['status'] = 'error';
    		$data['message'] = 'criteria failed to add';
    	}

    	return response()->json($data);
    }

	public function update(Request $request, $id) {
    	$input = $request->only(['name']);

    	$criteria = Criteria::where('id', $id)->first();
    	if ($criteria->update($input)) return response()->json(['success' => 'data_dapat_diperbarui'], 200);
    	else return response()->json(['error' => 'cant_update_data'], 500);
    }

    public function delete($id) {
		$tag = Criteria::where('tag', $id)->delete();
		$params = [
			'status' => "success",
			'message' => "criteria telah dihapus",
		];

        return json_encode($params);
    }

}
