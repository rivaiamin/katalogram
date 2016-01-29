<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\User;
use App\MemberContact;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth');
     }

    public function memberProfile($username)
    {
        $user['member'] = User::with(['member'])->where('name', $username)->get();
        $user_id = $user['member']->first()->id;

        // dd($user_id);
        $user['catalog'] = Product::where('user_id', $user_id)->get();
        $user['collect'] = $user['catalog']->category()->first();
        $user['contact'] = MemberContact::where('user_id', $user_id)->first();

        // dd($userM);
        return json_encode($user);
    }

    public function updateMember(Request $request, $username)
    {
        // masih error untuk menggunakan MemberRequest, karena token jadi terkirim dan dianggap tidak cocok denga field di member
        // $input = $request->all();

        $input = $request->only('member_name','member_born','member_gender','member_summary','member_profile','member_website','member_type','member_category');

        $user = User::where('name', $username)->first();

        // dd($input);

        $user->member()->update($input);

        if ($user->first()){

            $params = [
                'status' => "success",
                'message' => "Data profil member telah diperbarui",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "Data profil gagal diperbarui",
            ];
        }
        
        return json_encode($params);
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
