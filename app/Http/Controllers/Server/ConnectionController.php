<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class ConnectionController extends Controller
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
    public function addConnection($username)
    {

        $userName = Auth::user()->name;
        $memberId = User::where('name', $username)->first()->member;
        // dd($input);
        $input['member_id'] = $memberId->id;
        // dd(Auth::user()->name);

        $connect = User::where('name', $userName)->first()->memberContact()->create($input);

        if($connect){
            $params = [
                'status' => "success",
                'message' => "telah dihubungkan",
            ];
        }

        return json_encode($params);

    }

    public function removeConnection($username)
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
