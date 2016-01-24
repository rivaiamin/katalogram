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
        $user = User::where('name', $username)->first();
        $user['catalog'] = Product::where('user_id', $user->id)->get();
        $user['contact'] = MemberContact::where('user_id', $user->id)->first();

        // dd($userM);
        return json_encode($user);
    }

    public function updateMember(Request $request, $username)
    {

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
