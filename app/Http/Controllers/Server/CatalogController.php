<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\CatalogRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['catalogList'] = Product::with(['owner','category'])
                                ->where('deleted_at', NULL)
                                ->get();

        // $data['catalogList'] .= 'amm';

        return json_encode($data);
    }

    public function categoryProduct($id)
    {
        $data['catalogList'] = Product::with(['owner','category'])
                                ->where('deleted_at', NULL)
                                ->where('category_id', $id)
                                ->get();

        // $data['catalogList'] .= 'amm';

        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequest $request)
    {
        $input = $request->all();

        // return $input;

        Product::create($input);

        return Redirect::back();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequest $request, $id)
    {
        $catalog = Product::findOrFail($id);

        $input = $request->all();

        // return $input;

        $catalog->update($input);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catalog = Product::findOrFail($id);

        $input['deleted_at'] = Carbon::now();

        // return $input;

        $catalog->update($input);

        return redirect('/catalog');
    }
}
