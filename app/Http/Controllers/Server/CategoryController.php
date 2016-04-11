<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['index','detail']]);
    }

    public function index() {
    	$data['category'] = Category::all();
        
        return response()->json($data);
    }

    public function detail($id) {
        $data['category'] = Category::find($id);
        return response()->json($data);        
    }    
    
    public function add(Request $request) {
    	$input = $request->all();
        
		$save = Category::create($input);

    	if ($save) {
    		$data['status'] = 'success';
    		$data['message'] = 'category added';
    		$data['category'] = $save;
    	} else {
    		$data['status'] = 'error';
    		$data['message'] = 'category failed to add';
    	}
	
    	return response()->json($data);
    }
    
    public function uploadIcon(Request $r) {
        $video = Input::file('image');
    	
    	//var_dump($video);
    	if (Input::hasFile('image')) {
	        $destinationPath = base_path() . '/storage/files/category';
	        if(!$video->move($destinationPath, $video->getClientOriginalName())) {
	            return response()->json(['status' => 'error', 'message' => 'cant_upload'], 400);
	        } else {
	        	return response()->json(['status' => 'success', 'message' => 'upload'], 200);
	        }
		} else {
	        return response()->json(['status' => 'error', 'message' => 'empty'], 400);
		}
    }
    
    public function update(Request $request, $id) {
    	$input = $request->all();
        
    	$category = Category::where('id', $id)->first();
    	if ($category->update($input)) return response()->json(['success' => 'data_dapat_diperbarui'], 200);
    	else return response()->json(['error' => 'cant_update_data'], 500);
    }

    public function delete($id) {
    	$delete = Category::where('id', $id)->delete();

    	if ($delete) {
    		$data['status'] = 'success';
    		$data['message'] = 'category deleted';
    	} else {
    		$data['status'] = 'error';
    		$data['message'] = 'category failed to delete';
    	}

    	return response()->json($data);
    }
}
