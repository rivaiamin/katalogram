<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MemberCollect;
use Auth;

class CollectionController extends Controller
{

    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add($productId)
    {
        $input = [
            'product_id' => $productId,
            'user_id' => Auth::user()->id
        ];
        $collect = MemberCollect::create($input);

        if($collect){
            $params = [
                'status' => "success",
                'message' => "produk telah ditambahkan ke koleksi",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "produk gagal ditambahkan ke koleksi",
            ];
        }

        return json_encode($params);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
