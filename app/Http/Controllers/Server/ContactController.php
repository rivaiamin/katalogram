<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\User;
use App\MemberContact;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class ContactController extends Controller
{

    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //TODO: fixing addContact
    public function addContact($memberId)
    {

        $input['user_id'] = Auth::user()->id;
        
        $input['member_id'] = $memberId;
        // dd(Auth::user()->name);

        /*$contact = MemberContact::create($input);

        if($contact){
            $params = [
                'status' => "success",
                'message' => "telah dihubungkan",
            ];
        }*/

        return json_encode($input);

    }

    //TODO: fixing removeContact
    public function removeContact($username)
    {
        $userName = Auth::user()->name;
        $memberId = User::where('name', $username)->first()->member;
        // dd($input);
        $data = $memberId->id;

        $connect = User::where('name', $userName)->first()->memberContact()->where('member_id', $data)->delete();
        $params = [
            'status' => "success",
            'message' => "kriteria telah dihapus",
        ];
        
        return json_encode($params);
    }

   
}
