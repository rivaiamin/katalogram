<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\UserProfile;
use App\UserContact;
use App\UserCollect;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
//use App\Http\Requests\UserRequest;
use App\Http\Controllers\Auth\AuthenticateController as AuthCtrl;

class UserController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except'=>['profile']]);
     }

    public function index() {
        $data['user'] = User::all();
		return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    public function profile(User $user, $username) {

        $data['user'] = User::with(['userProfile','userProduct','userCollect.product','userLink','userContact.contact','userConnect.user'])
			->where('name',$username)->first();
        //$user_id = $data['user']->id;
        //$data['catalogs'] = User::find($user_id)->product();
        /*if ($auth->isOwner($username)) {
            $data['draft'] = Product::with(['user','category'])
                                ->where('is_release', '0')
                                ->where('user_id', $user_id)
                                ->get();;
        }
*/
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

    public function edit(AuthCtrl $auth, $username) {
        if ($auth->isOwner($username)) {
            $data['user'] = User::with('userProfile')->where('name', $username)->first();
			return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
        } else return response()->json(['error' => 'invalid_access'], 500);
    }

    public function updateProfile(AuthCtrl $auth, Request $request, $username)
    {
        // masih error untuk menggunakan UserRequest, karena token jadi terkirim dan dianggap tidak cocok denga field di member

        if ($auth->isOwner($username)) {
            $input = $request->only('fullname','born','picture','cover','location','summary','profile');
            $user = User::where('name','=',$username)->first()->profile;

            if ($user->update($input)){
                $data = [
                    'status' => "success",
                    'message' => "Data profil member telah diperbarui",
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

    public function changePict(Request $request, AuthCtrl $auth, $username)
    {
        /*$user = User::where('name', $username);
		$input = $request->only('picture');

        $user->update($input);

        if ($user->first()){
            $data = [
                'status' => "success",
                'message' => "gambar profile diperbarui",
            ];
        }
        else {
            $data = [
                'status' => "error",
                'message' => "gambar gagal diperbarui",
            ];
        }*/

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
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user->delete()){
            $data = [
                'status' => "success",
                'message' => "data berhasil dihapus",
            ];
			return response()->json($data, 200);
        } else {
            $data = [
                'status' => "error",
                'message' => "data gagal dihapus",
            ];
			return response()->json($data, 500);
        }

    }
}
