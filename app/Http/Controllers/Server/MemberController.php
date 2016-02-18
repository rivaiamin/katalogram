<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Member;
use App\MemberContact;
use App\MemberCollect;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\MemberRequest;
use App\Http\Controllers\Auth\AuthenticateController as AuthCtrl;

class MemberController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except'=>['memberProfile']]);
     }

    public function memberProfile(AuthCtrl $auth, $username)
    {
        
        $data['user'] = User::with('member')->where('name', $username)->first();
        $userId = $data['user']->id;
        $data['catalog'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
                                ->where('deleted_at', NULL)
                                ->where('product_release', '1')
                                ->where('user_id', $userId)
                                ->get();
        /*$data['member'] = DB::table('member')
                            ->join('users', 'member.user_id', '=', 'users.id')
                            ->select('member.*','users.id','users.name','users.user_pict', 'users.email')
                            ->where('users.name' , '=', $userId)
                            ->orWhere('users.id', '=', $userId)
                            ->take(1)
                            ->get();*/                       
        if ($auth->isOwner($username)) {
            $data['draft'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
                                ->where('deleted_at', NULL)
                                ->where('product_release', '0')
                                ->where('user_id', $userId)
                                ->get();;
        }

        $data['collect'] = [];
        $data['contact'] = [];
        $data['connect'] = [];
        $data['preview'] = Product::where('user_id', $userId)
                            ->join('product_preview','product.id','=','product_preview.product_id')
                            ->select('product_preview.preview_pict')
                            ->get();

        /*$product = Product::where('user_id', $user->id)->get();

        $prod = $product->toArray();
*/
        // $test = $product->criteria()->get();
        // dd($prod);

        // dd($user->id);
        // $user['catalog'] = Product::with('criteriaCount')->where('user_id', $user->id)->get();
        // $user['contact'] = MemberContact::where('user_id', $user->id)->get();
        // $user['collect'] = User::memberContact()->get();
        return json_encode($data);
    }

    public function editMember(AuthCtrl $auth, $username) {
        if ($auth->isOwner($username)) {
            $data['user'] = User::with('member')->where('name', $username)->first();
            return json_encode($data);
        } else return response()->json(['error' => 'invalid_access'], 500);
    }

    public function updateMember(AuthCtrl $auth, Request $request, $username)
    {
        // masih error untuk menggunakan MemberRequest, karena token jadi terkirim dan dianggap tidak cocok denga field di member
        
        if ($auth->isOwner($username)) {
            $input = $request->only('member_name','member_born','member_gender','member_summary','member_profile','member_website');
            $member = User::where('name','=',$username)->first()->member;

            if ($member->update($input)){
                $params = [
                    'status' => "success",
                    'message' => "Data profil member telah diperbarui",
                ];
            }
            else {
                $params = [
                    'status' => "error",
                    'message' => "Data profil gagal diperbarui"
                ];
            }
            
        } else {
            $params = [
                    'status' => "error",
                    'message' => "Tidak diperbolehkan"
                ];
        }

        //return json_encode($params);
    }

    public function changePict(Request $request, $username)
    {
        // dd($username);

        $user = User::where('name', $username);

        $input = $request->only('user_pict');

        // dd($input);

        $user->update($input);

        if ($user->first()){

            $params = [
                'status' => "success",
                'message' => "gambar profile diperbarui",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "gambar gagal diperbarui",
            ];
        }
        
        return json_encode($params);


    }
}