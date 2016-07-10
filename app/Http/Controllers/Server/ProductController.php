<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManager;
use App\Product;
use App\User;
use App\Category;
use App\Http\Controllers\Server\UserCollectController;
//use App\Criteria;
//use App\Tag;
use App\ProductTag;
use App\ProductCriteria;
use mikehaertl\wkhtmlto\Image;
use Auth;
use Storage;
use Endroid\QrCode\QrCode;
use App\Http\Controllers\Auth\AuthenticateController as AuthCtrl;

class ProductController extends Controller {

    public function __construct() {
         // Apply the jwt.auth middleware to all methods in this controller
         $this->middleware('jwt.auth', ['except' => ['get', 'export', 'detail', 'view', 'share', 'catalog', 'qrcode']]);
     }

	public function index(Product $product, $categoryId = null) {
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
		$category = $request->input('category');
		$tags = $request->input('tags');

    	$lists = $product->productList()
			->orderBy($product->table.'.id', 'desc')
			->take($limit);

		if (!empty($category)) {
			$cat = Category::where('slug', $category)->first();
			$lists->where('category_id', $cat->id);
		}
		if ($after != 0) $lists->where($product->table.'.id','<', $after);

        $data['catalogs'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function isOwner($id) {
        $product = Product::where('id',$id)->first();
        if ($product->user_id == Auth::user()->id) return true;
        else return false;
    }

    public function detail(AuthCtrl $auth, $id) {
        $data['product'] = Product::with(['user','category','productTag.tag','productCriteria.criteria','feedbackPlus','feedbackMinus'])->find($id);

		if ($user = $auth->getAuthUser(false)) $data['product']['is_collect'] = User::find($user->id)->isCollect($id);

		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function view($id) {
        $data['product'] = Product::with(['user','category','productTag.tag','productCriteria.criteria'])->find($id);
        $data['files'] = 'http://files.'.env('APP_DOMAIN');
		if (! Storage::has('product/qrcode/'.$id.'.png')) $this->qrcode($id, false);
		return view('catalog/view', $data);
    	//dd($data);
	}

	public function share($id) {
		$data['product'] = Product::with(['user','category'])->find($id);
        $data['files'] = 'http://files.'.env('APP_DOMAIN');
		return view('catalog/share', $data);
	}

    public function search(Request $request, $tag){

        $input = $request->except('token');

        $tagId = Tag::whereIn('tag_name', $input)->get(array('id'));
        $productId = ProductTag::whereIn('tag_id', $tagId)->groupBy('product_id')->get(array('product_id'));
        $data['lists'] = Product::whereIn('id', $productId)->get();

        // $data['lists'] = Tag::where('tag_name', $tag)->first()->product()->get();

        return json_encode($data);
    }

    public function create(ProductRequest $request) {
        $input = $request->only('category_id','name');
        $input['user_id'] = Auth::user()->id;

		$create = Product::create($input);

        if ($create) {
            $data['status'] = "success";
            $data['message'] = "katalog produk telah ditambahkan";
			$this->qrcode($create-id, false);
            $data['product_id'] = $create->id;
        } else {
            $data['status'] = "error";
            $data['message'] = "katalog produk gagal ditambahkan";
        }

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function edit(ProductCriteria $criteria, $id) {
        $data['product'] = Product::with(['user','productCriteria.criteria','productTag.tag'])
                                ->where('id', $id)
                                ->where('user_id', Auth::user()->id)
                                ->first();
		//$data['productCriteria'] = $criteria->criteria();
		//$data['productTag'] = ProductTag::where('product_id', $id)->tag()->get();
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request, $id) {
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

	public function setRateAvg($id) {
		$product = Product::where('id', $id);
		$criteria = $product->first()->productCriteria()->where('rate_avg','>','0');
		$row = $criteria->count();
		$total = $criteria->sum('rate_avg');
		$input['rating_avg'] = $total / $row;
		if ($product->update($input)) return true;
		else return false;
	}

    public function delete($productId) {
        if ($this->isOwner($productId)) {
			$catalog = Product::where('id', $productId)
					   ->where('user_id', Auth::user()->id);

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

    public function logoUpload($id) {
        if ($this->isOwner($id)) {
			$file = Input::file('image');

			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/product/logo/';
				$filename = time() . '.jpg';
				$manager = new ImageManager(array('driver' => 'imagick'));
				$image = $manager->make($file);

				if(!$image->fit(256)->encode('jpg',80)->save($destinationPath.$filename)) {
					return response()->json(['status' => 'error', 'message' => 'gambar gagal diubah'], 400);
				} else {
					//update record in database
					$input['logo'] = $filename;
					$update = Product::find($id);
					$update->update($input);
					return response()->json(['status' => 'success', 'message' => 'gambar berhasil diubah', 'logo' => $filename], 200);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'unauthorized'], 400);
		}
    }

    public function pictureUpload($id) {
        if ($this->isOwner($id)) {
			$file = Input::file('image');

			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/product/picture/';
				$filename = time() . '.jpg';
				$manager = new ImageManager(array('driver' => 'imagick'));
				$image = $manager->make($file);

				if(!$image->fit(600,250)->encode('jpg',80)->save($destinationPath.$filename)) {
					return response()->json(['status' => 'error', 'message' => 'gambar gagal diubah'], 400);
				} else {
					//update record in database
					$input['picture'] = $filename;
					$update = Product::find($id);
					$update->update($input);
					return response()->json(['status' => 'success', 'message' => 'gambar berhasil diubah', 'picture' => $filename], 200);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'unauthorized'], 400);
		}
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

		//using phantomjs
		/*$page = "http://api.".env('APP_DOMAIN').'/catalog/'.$productId.'/view';
		$conv = new \Anam\PhantomMagick\Converter;
		$conv->source($page)
			//->setBinary()
			->width(600)
			->quality(90)
			->toJpg()
			->download($productId.'-'.time().'.jpg');*/
    }

	public function qrcode($productId, $view = true) {
		$qrCode = new QrCode();
		$qrCode->setText(env('APP_URL').'/catalog/'.$productId.'/view')
			->setSize(256)
			->setPadding(10)
			->setErrorCorrection('high')
			->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
			->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
			->setImageType(QrCode::IMAGE_TYPE_PNG);

		Storage::put('product/qrcode/'.$productId.'.png', $qrCode->get());

		return response($qrCode->get(), 200, array('Content-Type' => $qrCode->getContentType()));
		/*if ($view == true) {
			header('Content-Type: '.$qrCode->getContentType());
			$qrCode->render();
		}*/
	}
}
