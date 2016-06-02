<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
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

class ProductController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         $this->middleware('jwt.auth', ['except' => ['get', 'export', 'detail', 'view', 'catalog']]);
     }

	public function index(Product $product, $categoryId = null)
    {
        /*$data['lists'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
            ->where('product_release', '1')
            ->where('deleted_at', NULL)
            ->get();*/
        $lists = $product->productList();

        if ($categoryId != null) $lists->where('category_id', $categoryId);
        $data['lists'] = $lists->get();

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function get(Product $product, Request $request, $after = 0, $limit = 10) {
		$category_id = $request->input('category_id');
		$tags = $request->input('tags');

    	$lists = $product->productList()
			->orderBy($product->table.'.id', 'desc')
			->take($limit);

		if (!empty($category_id)) $lists->where('category_id', $category_id);
		if ($after != 0) $lists->where($product->table.'.id','<', $after);

        $data['catalogs'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function isOwner($id) {
        $product = Product::where('id',$id)->first();
        if ($product->user_id == Auth::user()->id) return true;
        else return false;
    }

    public function detail($id){
        $data['product'] = Product::with(['user','category','productTag.tag','productCriteria.criteria','feedbackPlus','feedbackMinus'])->find($id);
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function view($id) {
        $data['product'] = Product::with(['user','category','productTag.tag','productCriteria.criteria','feedbackPlus','feedbackMinus'])
                                ->where('id', $id)
                                ->get();

        return view('catalog/view', $data);
    }

    public function search(Request $request, $tag){

        $input = $request->except('token');

        $tagId = Tag::whereIn('tag_name', $input)->get(array('id'));
        $productId = ProductTag::whereIn('tag_id', $tagId)->groupBy('product_id')->get(array('product_id'));
        $data['lists'] = Product::whereIn('id', $productId)->get();

        // $data['lists'] = Tag::where('tag_name', $tag)->first()->product()->get();

        return json_encode($data);
    }

    public function create(CatalogRequest $request)
    {
        $input = $request->only('category_id','name');
        $input['user_id'] = Auth::user()->id;

		$create = Product::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "katalog produk telah ditambahkan";
            $data['product_id'] = $create->id;
        } else {
            $data['status'] = "error";
            $data['message'] = "katalog produk gagal ditambahkan";
        }

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function edit($id)
    {
        $data['product'] = Product::with(['owner','criteria','tag','preview'])
                                ->where('id', $id)
                                ->where('user_id', Auth::user()->id)
                                ->get();

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request, $id)
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

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function delete($id) {
        if ($this->isOwner($id)) {
			$catalog = Product::where('id', $id)
					   ->where('user_id', $userId);

			if ($catalog->delete()) {
				$data['status'] = "success";
				$data['message'] = "Data katalog produk telah dihapus";
        		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
			} else {
				$data['status'] = "error";
				$data['message'] = "Data katalog gagal dihapus";
        		return response()->json($data, 500, [], JSON_NUMERIC_CHECK);
			}
		} else {
			return response()->json($data, 400, [], JSON_NUMERIC_CHECK);
		}
	}

    public function logoUpload(Request $request, $productId)
    {
        if ($this->isOwner($productId)) {

			$logo = Input::file('image');

			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/product/logo/';
				$filename = time() . '.' . $logo->getClientOriginalExtension();
				if(!$icon->move($destinationPath, $filename)) {
					return response()->json(['status' => 'error', 'message' => 'cant_upload'], 400);
				} else {
					return response()->json(['status' => 'success', 'message' => 'upload', 'image' => $filename ], 200, [], JSON_NUMERIC_CHECK);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}
		    /*$product = Product::where('id', $productId);
            $input = $request->only('product_logo');
            $product->update($input);
            if ($product->first()){
                $data = [
                    'status' => "success",
                    'message' => "Logo ikon telah berhasil diperbarui",
                ];
            }
            else {
                $data = [
                    'status' => "error",
                    'message' => "Logo ikon gagal diperbarui",
                ];
            }*/
		} else {
            $data = [
                'status' => "error",
                'message' => "akses invalid",
            ];
			return response()->json($data, 400, [], JSON_NUMERIC_CHECK);
        }


    }

    public function pictureUpload(Request $request, $productId)
    {
        if ($this->isOwner($productId)) {
			$logo = Input::file('image');

			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/product/picture/';
				$filename = time() . '.' . $picture->getClientOriginalExtension();
				if(!$icon->move($destinationPath, $filename)) {
					return response()->json(['status' => 'error', 'message' => 'cant_upload'], 400);
				} else {
					return response()->json(['status' => 'success', 'message' => 'upload', 'image' => $filename ], 200, [], JSON_NUMERIC_CHECK);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}

            /*$product = Product::where('id', $productId);
            $input = $request->only('preview_pict', 'preview_caption');
            $input['product_id'] = $productId;
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
            }*/
        } else {
            $params = [
                'status' => "error",
                'message' => "akses invalid",
            ];
        }

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function export($productId) {
        // You can pass a filename, a HTML string or an URL to the constructor
        $binary = '../vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64';
        $image = new Image(array(
            // Explicitly tell wkhtmltopdf that we're using an X environment
            //'use-xserver',
            'binary'   => $binary,
            'format'   => 'jpg',
            'quality'   => '100',
            'width'    => '300',
            'debug-javascript' => true
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
        $image->setPage("http://".getenv('APP_DOMAIN')."/export.html#$productId");
        //$image->saveAs('/path/to/page.png');

        // ... or send to client for inline display
        //if (! $image->send()) return $image->getError();
        // ... or send to client as file download
        if (! $image->send("catalog_$productId.jpg")) return $image->getError();
    }
}
