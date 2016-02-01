<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\User;
use App\MemberContact;
use App\MemberCollect;
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
        $data['member'] = User::with('member')
                                ->where('name', $username)
                                ->get();

        $userId = $data['member']->first()->id;

        $data['catalog'] = Product::with(['owner','category','numPlus','numMinus','numCollect'])
                                ->where('deleted_at', NULL)
                                ->where('user_id', $userId)
                                ->get();

        $data['collect'] = "";
        $data['contact'] = "";
        $data['connect'] = "";

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

    public function updateMember(Request $request, $username)
    {
        // masih error untuk menggunakan MemberRequest, karena token jadi terkirim dan dianggap tidak cocok denga field di member

        $input = $request->except('token');
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