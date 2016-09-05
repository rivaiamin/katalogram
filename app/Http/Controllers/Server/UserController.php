<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Role;
use App\UserProfile;
use App\UserContact;
use App\UserCollect;
use App\Product;
use App\Category;
use App\Link;
use App\UserLink;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManager;
use Auth;
use Hash;
//use App\Http\Requests\UserRequest;
use App\Http\Controllers\Auth\AuthenticateController as AuthCtrl;

class UserController extends Controller {

    public function __construct() {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except'=>['profile','share', 'catalogView']]);
     }

    public function index() {
        $data['user'] = User::all();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function scroll($after, $limit, User $user, Request $request) {

    	$lists = $user->orderBy('id', 'desc')
				 ->take($limit);

		if ($after != 0) $lists->where('id','<', $after);
        $data['users'] = $lists->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function form() {
		$data['roles'] = Role::all();

        return response()->json($data);
	}

	public function add(Request $request, User $user) {
    	$input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $input['password'] = Hash::make($request->input('password'));
		$save = $user->create($input);

    	if (! $save) {
    		$data['status'] = 'error';
    		$data['message'] = 'user failed to add';
    	} else {
    		$data['status'] = 'success';
    		$data['message'] = 'user added';
			$inputProfile['user_id'] = $save->id;
			if($inputProfile != NULL) {
				UserProfile::create($inputProfile);
				$save->roles()->attach($request->input('role_id'));
			}
    		$data['user'] = $save;
    	}

    	return response()->json($data);
    }

	public function edit($id) {
		$data['user'] = User::with('roles')->find($id);

        return response()->json($data);
	}

	public function update(Request $request, $id) {
    	$input = $request->only('name','email','picture');
		if ($request->input('password') != '') $input['password'] = Hash::make($request->input('password'));

    	$user = User::find($id);
    	if ($user->update($input)) return response()->json(['succsess' => 'data_dapat_diperbarui'], 200);
    	else return response()->json(['error' => 'cant_update_data'], 500);
    }

    public function delete($id) {
    	$delete = User::where('id', $id)->delete();

    	if ($delete) {
    		$data['status'] = 'success';
    		$data['message'] = 'user deleted';
    	} else {
    		$data['status'] = 'error';
    		$data['message'] = 'user failed to delete';
    	}

    	return response()->json($data);
    }

    public function profile(User $user, AuthCtrl $auth, $username) {

        $data['user'] = User::with(['userProfile','userProduct','userProductDraft','userCollect.product','userLink.link','userContact.contact','userConnect.user'])
			->where('name',$username)->first();
		if ($user = $auth->getAuthUser(false)) {
			$data['user']['is_contact'] = UserContact::where([
				'user_id' 	=> $user->id,
				'contact_id'=> $data['user']['id'] ])
			->count();
		}
        /*$user_id = $data['user']->id;
        $data['catalogs'] = User::find($user_id)->product();
        if ($auth->isOwner($username)) {
            $data['draft'] = Product::with(['user','category'])
                                ->where('is_release', '0')
                                ->where('user_id', $user_id)
                                ->get();;
        }*/

        //$data['collects'] = $user->userCollect()->product();
        //$data['contacts'] = $user->userContact()->get();
        //$data['connects'] = $user->userContact()
        //                    ->where('user_id', $user_id);
        //$data['is_contact'] = $user->isConnect(Auth::user()->id, $userId);

        // $user['catalog'] = Product::with('criteriaCount')->where('user_id', $user->id)->get();
        // $user['contact'] = UserContact::where('user_id', $user->id)->get();
        // $user['collect'] = User::memberContact()->get();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

	public function catalogView($username) {
		$data['user'] = User::with(['userProduct'])->where('name',$username)->first();
		$data['categories'] = Category::all();
		$data['catalogs'] = $data['user']['userProduct'];
		$data['files'] = 'http://files.'.env('APP_DOMAIN');

		return view('user/catalog', $data);
	}

	public function share($username) {
		$data['user'] = User::with(['userProfile'])->where('name', $username)->first();
		$data['files'] = 'http://files.'.env('APP_DOMAIN');
		return view('user/share', $data);
	}

    public function editProfile(AuthCtrl $auth, $username) {
        if ($auth->isOwner($username)) {
            $data['user'] = User::with('userProfile','userLink')->where('name', $username)->first();
			$data['links'] = Link::all();
			return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
        } else return response()->json(['error' => 'invalid_access'], 500);
    }

    public function updateProfile(AuthCtrl $auth, Request $request, $username) {
        // masih error untuk menggunakan UserRequest, karena token jadi terkirim dan dianggap tidak cocok denga field di member

        if ($auth->isOwner($username)) {
            $input = $request->only('fullname','born','cover','location','summary','profile');
            $user = User::where('name','=',$username)->first()->userProfile;

            if ($user->update($input)){
                $data = [
                    'status' => "success",
                    'message' => "Data profil telah diperbarui",
                ];
				return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
            }
            else {
                $data = [
                    'status' => "error",
                    'message' => "Data profil gagal diperbarui"
                ];
				return response()->json($data, 500, [], JSON_NUMERIC_CHECK);
            }
        } else {
            $data = [
                    'status' => "error",
                    'message' => "Tidak diperbolehkan"
                ];
				return response()->json($data, 400, [], JSON_NUMERIC_CHECK);
        }
	}

	public function uploadPicture(AuthCtrl $auth, $username) {
		if ($auth->isOwner($username)) {
			$file = Input::file('image');

			//var_dump($picture);
			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/user/picture/';
				$filename = time() . '.jpg';
				$manager = new ImageManager(array('driver' => 'imagick'));
				$image = $manager->make($file);

				if(!$image->fit(256)->encode('jpg',80)->save($destinationPath.$filename)) {
					return response()->json(['status' => 'error', 'message' => 'gambar gagal diubah'], 400);
				} else {

					//create thumbnail
					$thumb = $manager->make($file);
					$thumb->fit(64)->save($destinationPath.'thumb/'.$filename);

					//update record in database
					$input['picture'] = $filename;
					$update = User::where('name', $username)->first();
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

	public function uploadCover(AuthCtrl $auth, $username) {
		if ($auth->isOwner($username)) {
			$file = Input::file('image');

			//var_dump($cover);
			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/user/cover/';
				$filename = time() . '.jpg';
				$manager = new ImageManager(array('driver' => 'imagick'));
				$image = $manager->make($file);

				if(!$image->fit(1366,300)->encode('jpg',80)->save($destinationPath.$filename)) {
					return response()->json(['status' => 'error', 'message' => 'gambar gagal diubah'], 400);
				} else {
					$input['cover'] = $filename;
					$update = User::where('name', $username)->first()->userProfile;
					$update->update($input);
					return response()->json(['status' => 'success', 'message' => 'gambar berhasil diubah', 'cover' => $filename], 200);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'unauthorized'], 400);
		}
	}

    /*public function changePict(Request $request, AuthCtrl $auth, $username) {
        $user = User::where('name', $username);
		$input = $request->only('picture');

        $user->update($input);

		if ($auth->isOwner($username)) {
			$logo = Input::file('image');

			if (Input::hasFile('image')) {
				$destinationPath = base_path() . '/storage/files/user/picture/';
				$filename = time() . '.' . $picture->getClientOriginalExtension();
				if(!$icon->move($destinationPath, $filename)) {
					return response()->json(['status' => 'error', 'message' => 'cant_upload'], 400);
				} else {
					return response()->json(['status' => 'success', 'message' => 'upload', 'image' => $filename ], 200, [], JSON_NUMERIC_CHECK);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'empty'], 400);
			}
        } else {
            $data = [
                'status' => "error",
                'message' => "akses invalid",
            ];
        	return response()->json($data, 400);
        }
    }*/

	public function addLink(Request $request, AuthCtrl $auth, $username) {
		if ($auth->isOwner($username)) {
			$input = $request->input('all');
			$input['user_id'] = Auth::user()->id;
			$input['link_id'] = $request->input('link');
			$input['url'] = $request->input('url');

			$save = UserLink::create($input);

			if ($save) {
				Auth::user()->increment('contact_count');
				User::find($input['link_id'])->increment('connect_count');
				$data['status'] = 'success';
				$data['message'] = 'link ditambahkan';
				$data['link'] = $save;
			} else {
				$data['status'] = 'error';
				$data['message'] = 'link gagal ditambahkan';
			}

		} else {
			$data['status'] = 'error';
			$data['message'] = 'tidak diperbolehkan';
		}

		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
	}

	public function removeLink(AuthCtrl $auth, $username, $id) {
		if ($auth->isOwner($username)) {
			$delete = UserLink::where('id', $id)->delete();

			if ($delete) {
				Auth::user()->decrement('contact_count');
				User::find($input['link_id'])->decrement('connect_count');
				$data['status'] = 'success';
				$data['message'] = 'link terhapus';
			} else {
				$data['status'] = 'error';
				$data['message'] = 'link gagal dihapus';
			}

		} else {
			$data['status'] = 'error';
			$data['message'] = 'tidak diperbolehkan';
		}
    	return response()->json($data);

	}

}
