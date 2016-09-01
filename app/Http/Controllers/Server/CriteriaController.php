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

		$save = Criteria::create($input);

    	if ($save) return response()->json(['success' => 'kriteria ditambahkan', 'criteria' => $save], 200);
    	else return response()->json(['error' => 'kriteria gagal ditambahkan'], 500);

    	return response()->json($data);
    }

	public function update(Request $request, $id) {
    	$input = $request->only(['name']);

    	$criteria = Criteria::where('id', $id)->first();
    	if ($criteria->update($input)) return response()->json(['success' => 'kriteria diperbarui'], 200);
    	else return response()->json(['error' => 'kriteria gagal diperbarui'], 500);

    }

    public function delete($id) {
		$delete = Criteria::find($id)->delete();

		if ($delete) return response()->json(['success' => 'criteria dihapus'], 200);
		else return response()->json(['error' => 'kriteria gagal dihapus'], 500);

    }

}
