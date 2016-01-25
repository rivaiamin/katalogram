<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Config;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use App\User;

class AuthenticateController extends Controller
{

    public function __construct()
     {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth', ['except' => ['login', 'register','facebook', 'google']]);
     }

    public function index()
    {
        // Retrieve all the users in the database and return them
        $users = User::all();
        return $users;
    }

    public function getAuthenticatedUser()
    {
        /*try {


        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }*/

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function store(UserRequest $request)
    {
        // User::create($request::all());
        $input = $request->all();
        $input['level_id'] = 3;

        // return $input;

        User::create($input);

        return Redirect::back()->with('flash_message', 'User has been created');
    }
    
    public function login(Request $request)
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

    public function register(UserRequest $request)
    {
        $input = $request->all();
        $input['level_id'] = 3;
        // return $input;
        User::create($input);

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

    /**
     * Login with Facebook.
     */
    public function facebook(Request $request)
    {
        $client = new GuzzleHttp\Client();

        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'redirect_uri' => $request->input('redirectUri'),
            'client_secret' => Config::get('app.facebook_secret')
        ];

        // Step 1. Exchange authorization code for access token.
        $accessTokenResponse = $client->request('GET', 'https://graph.facebook.com/v2.5/oauth/access_token', [
            'query' => $params
        ]);
        $accessToken = json_decode($accessTokenResponse->getBody(), true);

        // Step 2. Retrieve profile information about the current user.
        $fields = 'id,email,first_name,last_name,link,name';
        $profileResponse = $client->request('GET', 'https://graph.facebook.com/v2.5/me', [
            'query' => [
                'access_token' => $accessToken['access_token'],
                'fields' => $fields
            ]
        ]);
        $profile = json_decode($profileResponse->getBody(), true);

        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        // Step 3a. If user is already signed in then link accounts.
        if ($request->header('Authorization'))
        {
            $user = User::where('facebook', '=', $profile['id']);

            if ($user->first())
            {
                return response()->json(['message' => 'Akun facebook tersebut sudah terdaftar'], 409);
            }

            $token = explode(' ', $request->header('Authorization'))[1];
            $payload = JWTAuth::decode($token, $customClaims);

            $user = User::find($payload['sub']);
            $user->facebook = $profile['id'];
            $user->email = $user->email ?: $profile['email'];
            $user->name = $user->name ?: $profile['name'];
            $user->save();

            $token = JWTAuth::fromUser($user, $customClaims);
            return response()->json(['token' => $token]);
        }
        // Step 3b. Create a new user account or return an existing one.
        else
        {
            $user = User::where('facebook', '=', $profile['id']);

            if ($user->first())
            {
                return response()->json(['token' => JWTAuth::fromUser($user->first(), $customClaims)]);
            }

            $user = new User;
            $user->level_id = '3';
            $user->facebook = $profile['id'];
            $user->email = $profile['email'];
            $user->name = $profile['name'];
            $user->save();

            $token = JWTAuth::fromUser($user, $customClaims);
            return response()->json(['token' => $token]);
        }
    }

    /**
     * Login with Google.
     */
    public function google(Request $request)
    {
        $client = new GuzzleHttp\Client();

        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'client_secret' => Config::get('app.google_secret'),
            'redirect_uri' => $request->input('redirectUri'),
            'grant_type' => 'authorization_code',
        ];

        // Step 1. Exchange authorization code for access token.
        $accessTokenResponse = $client->request('POST', 'https://accounts.google.com/o/oauth2/token', [
            'form_params' => $params
        ]);
        $accessToken = json_decode($accessTokenResponse->getBody(), true);

        // Step 2. Retrieve profile information about the current user.
        $profileResponse = $client->request('GET', 'https://www.googleapis.com/plus/v1/people/me/openIdConnect', [
            'headers' => array('Authorization' => 'Bearer ' . $accessToken['access_token'])
        ]);
        $profile = json_decode($profileResponse->getBody(), true);

        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        // Step 3a. If user is already signed in then link accounts.
        if ($request->header('Authorization'))
        {
            $user = User::where('google', '=', $profile['sub']);

            if ($user->first())
            {
                return response()->json(['message' => 'Akun google tersebut sudah terdaftar'], 409);
            }

            $token = explode(' ', $request->header('Authorization'))[1];
            $payload = JWTAuth::decode($token, $customClaims);
            
            $user = User::find($payload['sub']);
            $user->google = $profile['sub'];
            $user->name = $user->name ?: $profile['name'];
            $user->save();

            return response()->json(['token' => JWTAuth::fromUser($user, $customClaims)]);
        }
        // Step 3b. Create a new user account or return an existing one.
        else
        {
            $user = User::where('google', '=', $profile['sub']);

            if ($user->first())
            {
                return response()->json(['token' => JWTAuth::fromUser($user->first(), $customClaims)]);
            }

            $user = new User;
            $user->level_id = '3';
            $user->google = $profile['sub'];
            $user->name= $profile['name'];
            $user->save();

            return response()->json(['token' => JWTAuth::fromUser($user, $customClaims)]);
        }
    }
    
}
