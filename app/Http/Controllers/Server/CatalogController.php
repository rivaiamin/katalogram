<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\CatalogRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Tag;
use mikehaertl\wkhtmlto\Image;
use Auth;

class CatalogController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it

         $this->middleware('jwt.auth', ['except' => ['exportCatalog', 'viewCatalog', 'index', 'catalogCategory', 'catalogDetail']]);
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['lists'] = Product::with(['owner','category','avgScore','numPlus','numMinus','numCollect'])
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
        /*$data = Product::with(['avgScore'])
                                ->where('id', $id)
                                ->get();*/
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
    public function createCatalog(CatalogRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        //return $input;

        $create = Product::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "katalog produk telah ditambahkan";
            $data['product_id'] = $create->id;
        } else {
            $data['status'] = "error";
            $data['message'] = "katalog produk gagal ditambahkan";
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
    public function editCatalog($id)
    {
        $data['product'] = Product::with(['owner','criteria','tags','preview'])
                                ->where('id', $id)
                                ->where('user_id', Auth::user()->id)
                                ->get();

        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCatalog(Request $request, $id)
    {
        $catalog = Product::findOrFail($id);

        $input = $request->all();

        // return $input;

        $catalog->update($input);

        if ($catalog) {
            $data['status'] = "success";
            $data['message'] = "Data katalog produk telah diperbarui";
        } else {
            $data['status'] = "error";
            $data['message'] = "Data katalog gagal diperbarui";
        }

        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = Auth::user()->id;
        // dd($userId);
        $catalog = Product::where('id', $id)
                            ->where('user_id', $userId);

        $input['deleted_at'] = Carbon::now();

        // return $input;

        $catalog->update($input);

        if ($catalog->first()) {
            $data['status'] = "success";
            $data['message'] = "Data katalog produk telah dihapus";
        } else {
            $data['status'] = "error";
            $data['message'] = "Data katalog gagal dihapus";
        }

        return json_encode($data);
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

    public function searchCatalog($tag){
        $data['lists'] = Tag::where('tag_name', $tag)->first()->product()->get();

        return json_encode($data);
    }
}
