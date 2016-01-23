<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Redirect;
use Hash;

class AuthenticateController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except' => ['authenticate']]);
     }

    public function index()
    {
        // Retrieve all the users in the database and return them
        $users = User::all();
        return $users;
    }

    public function store(Request $request)
    {
        // User::create($request::all());
        $input = $request->only('name', 'email','password','password_confirmation' );

        $input['level_id'] = 3;

        if($input['password'] == $input['password_confirmation']){
            // return $input;
            $input['password'] = Hash::make($input['password']);
            
            User::create($input);

            return Redirect::back()->with('flash_message', 'User has been created');
        }
        else {
            return Redirect::back()->with('flash_message', 'User failed');
        }


    }
    
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
    
}
