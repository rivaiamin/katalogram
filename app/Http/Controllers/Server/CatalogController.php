<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\CatalogRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Preview;
use App\Criteria;
use App\Tag;
use App\ProductTag;
use mikehaertl\wkhtmlto\Image;
use Auth;
//use App\Http\Controllers\Auth\AuthenticateController as AuthCtrl;

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
    public function index(Criteria $criteria, $categoryId = null)
    {
        /*$data['lists'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
            ->where('product_release', '1')
            ->where('deleted_at', NULL)
            ->get();*/  
        $lists = Product::select(DB::raw("product.id, product.product_name, product.product_logo, product.product_quote, product.category_id,
                users.name, users.user_pict, 
                category.category_icon,
                count(distinct(member_collect.id)) as num_collect,            
                count(case product_feedback.feedback_type when 'P' then 1 else null end) as num_plus,
                count(case product_feedback.feedback_type when 'N' then 1 else null end) as num_minus,
                avg(distinct(rate_criteria.avg)) as avg_rate"
            ))
            ->join('users','product.user_id','=','users.id')
            ->join('category','product.category_id','=','category.id')
            ->leftJoin('product_feedback','product.id','=','product_feedback.product_id')
            ->leftJoin($criteria->rateCriteria(),'rate_criteria.product_id','=','product.id')
            ->leftJoin('member_collect','product.id','=','member_collect.product_id')
            ->where('product.product_release', '1')
            ->where('product.deleted_at', NULL)
            ->groupBy('product.id')
            ->orderBy('product.id', 'desc');
            

        if ($categoryId != null) $lists->where('category_id', $categoryId);
        $data['lists'] = $lists->get();

        return json_encode($data);
    }
    
    public function isOwner($productId) {
        $product = Product::where('id',$productId)->first();
        if ($product->user_id == Auth::user()->id) return true;
        else return false;
    }


    public function catalogDetail($id){
        $data['product'] = Product::with(['owner','category','preview','criteria','tag','feedbackPlus','feedbackMinus','numCollect'])
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
        $input = $request->only('category_id','product_name');
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
        $data['product'] = Product::with(['owner','criteria','tag','preview'])
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
        if ($this->isOwner($id)) {
            $catalog = Product::findOrFail($id);

            $input = $request->all();

            $catalog->update($input);

            if ($catalog) {
                $data['status'] = "success";
                $data['message'] = "Data katalog produk telah diperbarui";
            } else {
                $data['status'] = "error";
                $data['message'] = "Data katalog gagal diperbarui";
            }
        } else {
            $data['status'] = "error";
            $data['message'] = "akses invalid";
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
        if ($this->isOwner($productId)) {
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
        } else {
            $params = [
                'status' => "error",
                'message' => "akses invalid",
            ];
        }
        
        return json_encode($params);
    }

    public function previewUpload(Request $request, $productId)
    {
        if ($this->isOwner($productId)) {
            $product = Product::where('id', $productId);

            $input = $request->only('preview_pict', 'preview_caption');
            $input['product_id'] = $productId;
            // dd($input);

            $preview = Preview::create($input);

            if ($preview){
                $params = [
                    'status' => "success",
                    'message' => "gambar tampilan telah ditambahkan",
                ];
            }
            else {
                $params = [
                    'status' => "error",
                    'message' => "gambar gagal ditambahkan",
                ];
            }
        } else {
            $params = [
                'status' => "error",
                'message' => "akses invalid",
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
        $data['product'] = Product::with(['owner','category','criteria','criteriaCount','tag','feedbackPlus','feedbackMinus','numPlus','numMinus','numCollect'])
                                ->where('id', $id)
                                ->get();

        return view('catalog/view', $data);
    }

    public function searchCatalog(Request $request, $tag){

        $input = $request->except('token');

        $tagId = Tag::whereIn('tag_name', $input)->get(array('id'));
        $productId = ProductTag::whereIn('tag_id', $tagId)->groupBy('product_id')->get(array('product_id'));
        $data['lists'] = Product::whereIn('id', $productId)->get();

        // dd($product);

        // $data['lists'] = Tag::where('tag_name', $tag)->first()->product()->get();

        return json_encode($data);
    }
}
