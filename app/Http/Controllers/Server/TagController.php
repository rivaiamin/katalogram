<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Tag;
use App\Product;
use App\ProductTag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\CatalogController as CatalogCtrl;

class TagController extends Controller
{
    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except'=>['index', 'get']] );
    }

	public function index() {
		$data = Tag::select('id','name')->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

	public function get($after, $limit, Tag $tag, Request $request) {
		$name = $request->input('name');

    	$lists = $tag->orderBy('id', 'desc')
				 ->take($limit);
		if (!empty($name)) $lists->where($school->table.'.name', 'like', "%$name%");
		if ($after != 0) $lists->where('id','<', $after);

        $data['tags'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function add(Request $request) {
		$input = $request->only(['name']);

		$save = Tag::create($input);

    	if ($save) return response()->json(['success' => 'tag ditambahkan', 'tag' => $save], 200);
    	else return response()->json(['error' => 'tag gagal ditambahkan'], 500);

    	return response()->json($data);
    }

	public function update(Request $request, $id) {
    	$input = $request->only(['name']);

    	$tag = Tag::where('id', $id)->first();
    	if ($tag->update($input)) return response()->json(['success' => 'tag diperbarui'], 200);
    	else return response()->json(['error' => 'tag gagal diperbarui'], 500);

    }

    public function delete($id) {
		$delete = Tag::find($id)->delete();

		if ($delete) return response()->json(['success' => 'tag dihapus'], 200);
		else return response()->json(['error' => 'tag gagal dihapus'], 500);

    }
}
