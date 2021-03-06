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
use App\ProductTag;
use App\ProductCriteria;
//use App\Http\Controllers\Server\UserCollectController;
//use App\Criteria;
//use App\Tag;
use mikehaertl\wkhtmlto\Image;
use Auth;
use Entrust;
use Storage;
use Endroid\QrCode\QrCode;
use Browshot;
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
		$tags = json_decode($request->input('tags'));

    	$lists = $product->productList()
			->join('product_tags', 'products.id', '=','product_tags.product_id')
			->orderBy($product->table.'.id', 'desc')
			->take($limit);

		if (!empty($category)) {
			$cat = Category::where('slug', $category)->first();
			$lists->where('category_id', $cat->id);
		}
		if (count($tags) > 0) {
				$lists->whereIn('product_tags.tag_id', $tags);
				$lists->havingRaw('count(products.id) = '.count($tags));
		}
		if ($after != 0) $lists->where($product->table.'.id','<', $after);
		if (! Entrust::hasRole(['admin','manager'])) $lists->where('products.is_release', '1');


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

		$data['product']->increment('view_count');

		if ($user = $auth->getAuthUser(false)) $data['product']['is_collect'] = User::find($user->id)->isCollect($id);

		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function view($id) {
        $data['product'] = Product::with(['user','category','productTag.tag','productCriteria.criteria'])->find($id);
        $data['files'] = 'http://files.'.env('APP_DOMAIN');

		if (! Storage::has('product/qrcode/'.$id.'.png')) $this->qrcode($id, false);
		return view('catalog/share', $data);
    	//dd($data);
	}

	/*public function share($id) {
		$data['product'] = Product::with(['user','category'])->find($id);
        $data['files'] = 'http://files.'.env('APP_DOMAIN');
		return view('catalog/share', $data);
	}*/

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
            $data['message'] = "Katalog telah tersimpan sebagai draft, harap lengkapi data sebelum publikasikan";
			$this->qrcode($create->id, false);
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

    public function update(Request $request, Category $category, $id) {
        if ($this->isOwner($id)) {
            $catalog = Product::findOrFail($id);

            $input = $request->all();

			if ($catalog->is_release == '0' && $input['is_release'] == '1') {
				$category->productInc($input['category_id']);
				Auth::user()->increment('product_count');
			} else if ($catalog->is_release == '1' && $input['is_release'] == '0') {
				$category->productDec($input['category_id']);
				Auth::user()->decrement('product_count');
			}

            $update = $catalog->update($input);

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

    public function delete(Category $category, $productId) {
        if ($this->isOwner($productId) || Auth::user()->hasRole(['manager', 'admin'])) {
			$catalog = Product::find($productId);

			$category->productDec($catalog->category_id);

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

				if(!$image->fit(600,400)->encode('jpg',80)->save($destinationPath.$filename)) {
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

    public function export($id) {

		//using phantomjs
		/*$page = "http://api.".env('APP_DOMAIN').'/catalog/'.$productId.'/view';
		$conv = new \Anam\PhantomMagick\Converter;
		$conv->source($page)
			//->setBinary()
			->width(600)
			->quality(90)
			->toJpg()
			->download($productId.'-'.time().'.jpg');*/


		// using page2images
		/*$data['product'] = Product::with(['user','category'])->find($id);
        $data['files'] = 'http://files.'.env('APP_DOMAIN');
		return view('catalog/image', $data);*/

		// use browshot
		$browshot = new Browshot('6EZNlkVJBXmbTxtCDqzNOfQQYmQ34gIZ');
		$image = $browshot->simple(['url' => 'http://api.'.env('APP_DOMAIN').'/catalog/'.$id.'/view', 'instance_id' => 12, 'screen_width'=>600, 'screen_height'=>600 ]);

		if ($image['code'] == '200') {
			$data['product'] = Product::with(['user','category'])->find($id);
        	$data['files'] = 'http://files.'.env('APP_DOMAIN');

			$data['filename'] = $id.'-'.time().'.png';
			$save = Storage::put('product/export/'.$data['filename'], $image['image']);
			if ($save) return view('catalog/image', $data);
			else return response()->json(['error'=>'storage_fail'], 500, [], JSON_NUMERIC_CHECK);
		} else return response()->json(['error'=>'screenshot_fail'], 500, [], JSON_NUMERIC_CHECK);
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

		//return response($qrCode->get(), 200, array('Content-Type' => $qrCode->getContentType()));
		if ($view == true) {
			header('Content-Type: '.$qrCode->getContentType());
			$qrCode->render();
		}
	}
}
