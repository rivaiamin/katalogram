<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\CatalogRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use mikehaertl\wkhtmlto\Image;

class CatalogController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it

         $this->middleware('jwt.auth', ['except' => ['exportCatalog', 'viewCatalog']]);
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['lists'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
                                ->where('deleted_at', NULL)
                                ->get();

        // $data['catalogList'] .= 'amm';

        return json_encode($data);
    }

    public function catalogCategory($id)
    {
        $data['catalogList'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
                                ->where('deleted_at', NULL)
                                ->where('category_id', $id)
                                ->get();

        // $data['catalogList'] .= 'amm';

        return json_encode($data);
    }

    public function catalogDetail($id){
        $data['product'] = Product::with(['owner','category','criteria','criteriaCount','tags','feedbackPlus','feedbackMinus','numPlus','numMinus','numCollect'])
                                ->where('id', $id)
                                ->get();

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

        //return $input;

        $create = Product::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "Katalog telah berhasil dibuat";
        } else {
            $data['status'] = "error";
            $data['message'] = "Katalog gagal dibuat";
        }

        return json_encode($data);
        //return Redirect::back();
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

    public function logoUpload(Request $request, $productId)
    {
        $product = Product::where('id', $productId);

        $input = $request->only('product_logo');

        // dd($input);

        $product->update($input);

        if ($product->first()){

            $params = [
                'status' => "success",
                'message' => "Logo ikon telah berhasil diperbarui",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "Logo ikon gagal diperbarui",
            ];
        }
        
        return json_encode($params);
    }

    public function exportCatalog($id) {
        // You can pass a filename, a HTML string or an URL to the constructor
        $binary = '../vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64';
        $image = new Image(array(
            // Explicitly tell wkhtmltopdf that we're using an X environment
            //'use-xserver',
            'binary'   => $binary,
            'format'   => 'jpg',
            'quality'   => '90',
            'width'    => '600'
            // Enable built in Xvfb support in the command
            /*'commandOptions' => array(
                'enableXvfb' => true,

                // Optional: Set your path to xvfb-run. Default is just 'xvfb-run'.
                // 'xvfbRunBinary' => '/usr/bin/xvfb-run',

                // Optional: Set options for xfvb-run. The following defaults are used.
                'xvfbRunOptions' => false
            )*/
        ));
        //$image->setPage("http://katalogram.dev");
        $image->setPage("http://api.".getenv('APP_DOMAIN')."/catalog/$id/view");
        //$image->saveAs('/path/to/page.png');

        // ... or send to client for inline display
        if (! $image->send()) return $image->getError();
        // ... or send to client as file download
        //if (! $image->send('catalog.jpg')) return $image->getError();
    }

    public function viewCatalog($id) {
        $data['product'] = Product::with(['owner','category','criteria','criteriaCount','tags','feedbackPlus','feedbackMinus','numPlus','numMinus','numCollect'])
                                ->where('id', $id)
                                ->get();

        return view('catalog/view', $data);
    }
}
