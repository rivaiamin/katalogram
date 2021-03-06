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
use App\Role;
use App\User;
use App\UserProfile;
use Redirect;
use Auth;
use Hash;

class AuthenticateController extends Controller {

    public function __construct() {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it

         $this->middleware('jwt.auth', ['except' => ['login', 'subscribe', 'register','facebook', 'google']]);
    }

    public function index() {
        // Retrieve all the users in the database and return them
        $users = User::all();
        return $users;
    }

    public function isOwner($userId) {
        $auth = JWTAuth::parseToken()->authenticate();

        if (($auth->name == $userId) or ($auth->id == $userId)) return true;
        else return false;
    }

    public function getAuthUser($json = true) {
        /*try {

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }*/
		if (JWTAuth::getToken()) {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				$data = ['message'=>'user_not_found'];
				$status = 404;
			} else {
				$data = ['user'=>$user];
				$status = 200;
			}
			if ($json == true) return response()->json($data, $status);
			else return $user;
		} return false;
		// the token is valid and we have found the user via the sub claim
	}

    public function login(Request $request) {
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
		$user = Auth::user();
        // all good so return the token
        return response()->json(compact('token','user'));
    }

	public function subscribe(Request $request) {
		$user = new User;
        $user->email = $request->input('email');
        $user->name = explode('@', $user->email)[0];
        $user->password = Hash::make($user->email);

		$exist = User::where('email', $user->email)->orWhere('name',$user->name);

		if (!$exist->first()) {
			if ($user->save()) {
				$return['status'] = 'success';
				$return['message'] = 'Terima kasih atas dukungannya, mohon tunggu kabar selanjutnya melalui email';
			} else {
				$return['status'] = 'error';
				$return['message'] = 'Mohon masukkan alamat email yang sesuai';
			}

			$inputProfile['user_id'] = $user->id;
			$inputProfile['fullname'] = $user->name;

			if($inputProfile != NULL) {
				UserProfile::create($inputProfile);
				$user->roles()->attach(3);
			}
		} else {
			$return['status'] = 'error';
			$return['message'] = 'Alamat email sudah ada, tolong masukkan alamat lain';
		}

		return response()->json($return, 200, [], JSON_NUMERIC_CHECK);

	}

    public function register(Request $request) {
        /*$input['level_id'] = '3';
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $input['password'] = ;*/
        
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $inputProfile['user_id'] = $user->id;
        $inputProfile['fullname'] = $request->input('name');
        
        if($inputProfile != NULL) {
            UserProfile::create($inputProfile);
            $user->roles()->attach(3);
        }

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

    public function change(Request $request, $username, $field) {
        if (($field == 'name') or ($field == 'email')) {
            $input = $request->only($field);
            $user = User::where($field, '=', $input['name']);
            if ($user->first()) {
                return response()->json(['error' => 'sudah ada akun dengan username atau email tersebut'], 409);
                //return response()->json(['token' => JWTAuth::fromUser($user->first(), $customClaims)]);
            } else {
                try {
					$user = User::where('name', '=', $username)->first();
					if ($field == 'name') $user->name = $input['name'];
					if ($field == 'email') $user->email = $input['email'];
					$user->save();
					return response()->json(['success' => 'Akun berhasil diperbarui, harap login ulang'], 200);
				} catch (Exception $e) {
                    return response()->json(['error' => 'Akun gagal diperbarui'], 500);
				}


            }
        } elseif ($field == 'password') {
            $input = $request->only('old','new','confirm');
            $user = User::where('name','=', $username)
                    ->where('password','=',Hash::make($input['old']));
            if (!$user->first()) {
                //return response()->json(['error' => 'password lama tidak cocok dengan data pengguna'], 403);
                return Hash::make($input['old']);
            } elseif ($input['new'] != $input['confirm']) {
                return response()->json(['error' => 'password baru dan konfirmasi password tidak sama'], 403);
            } else {
                if ($user->update(['password'=>Hash::make($input['new'])]))
                    return response()->json(['success' => 'password berhasil diubah'], 200);
            }
        }

    }

    public function changePass(Request $request, $username) {
        //if ($request->input(''))
    }

    /**
     * Login with Facebook.
     */
    public function facebook(Request $request)    {
        $client = new GuzzleHttp\Client();

        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'redirect_uri' => $request->input('redirectUri'),
            'client_secret' => Config::get('app.facebook_secret')
        ];

        // Step 1. Exchange authorization code for access token.
        $accessTokenResponse = $client->request('GET', 'https://graph.facebook.com/v2.3/oauth/access_token', [
            'query' => $params
        ]);
        $accessToken = json_decode($accessTokenResponse->getBody(), true);

        // Step 2. Retrieve profile information about the current user.
        $fields = 'id,email,first_name,last_name,link,name';
        $profileResponse = $client->request('GET', 'https://graph.facebook.com/v2.3/me', [
            'query' => [
                'access_token' => $accessToken['access_token'],
                'fields' => $fields
            ]
        ]);
        $profile = json_decode($profileResponse->getBody(), true);

        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        // Step 3a. If user is already signed in then link accounts.
        if ($request->header('Authorization')) {

			//check user facebook id
            $user = User::where('facebook', '=', $profile['id']);
            if ($user->first()) {
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
			//$user = Auth::user();
            return response()->json(['token' => $token, 'user' => $user]);
        } else {
			// Step 3b. Create a new user account or return an existing one.
            $user = User::where('facebook', '=', $profile['id']);
			$username = explode('@', $profile['email']);

			//jika akun facebook ditemukan langsung login, jika tidak akan dicek apakah akun dengan nama tersebut sudah ada atau belum
            if ($user->first()) {
                return response()->json(['token' => JWTAuth::fromUser($user->first(), $customClaims)]);
			} else if (User::where('name', $username)->orWhere('email', $profile['email'])->count() > 0) return response()->json(['message' => 'Akun dengan username serupa sudah terdaftar, silahkan daftar akun baru'], 409);

			$user = new User;
            $user->facebook = $profile['id'];
            $user->email = $profile['email'];
            $user->name = $username[0];
            //$user->name = $profile['name'];

			if ($user->save()) {

				$user->attachRole('3');

				$uProfile = new UserProfile;
				$uProfile->user_id = $user->id;
				$uProfile->fullname = $profile['name'];
				//$profile->profile = $profile['bio'];
				$uProfile->save();

				$token = JWTAuth::fromUser($user, $customClaims);

				$status = 'success';
				$message = 'Terima kasih atas dukungannya, mohon tunggu kabar selanjutnya melalui email';
			}


			//$user = Auth::user();
            //return response()->json(['token' => $token, 'user' => $user, 'message'=> $message, 'status' => $status]);
            return response()->json(['user' => $user, 'message'=> $message, 'status' => $status]);
        }
    }

    /**
     * Login with Google.
     */
    public function google(Request $request)   {
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
        if ($request->header('Authorization'))  {
            $user = User::where('google', '=', $profile['sub']);

            if ($user->first()) return response()->json(['message' => 'Akun google tersebut sudah terdaftar'], 409);

            $token = explode(' ', $request->header('Authorization'))[1];
            $payload = JWTAuth::decode($token, $customClaims);
            
            $user = User::find($payload['sub']);
            $user->google = $profile['sub'];
            $user->name = $user->name ?: $profile['name'];
            $user->save();

			JWTAuth::fromUser($user, $customClaims);
			//$user = Auth::user();
            return response()->json(['token' => $token, 'user' => $user]);
        } else {
		// Step 3b. Create a new user account or return an existing one.
            $user = User::where('google', '=', $profile['sub']);
            $username = explode('@', $profile['email']);

			if ($user->first())  {
                return response()->json(['token' => JWTAuth::fromUser($user->first(), $customClaims)]);
            } else if (User::where('name', $username)->orWhere('email', $profile['email'])->count() > 0) return response()->json(['message' => 'Akun dengan username serupa sudah terdaftar, silahkan daftar akun baru'], 409);

            //return response()->json(['profile' =>$profile]);
            
            $user = new User;
            $user->google = $profile['sub'];
            $user->name = $username[0];
            $user->email= $profile['email'];

			if ($user->save()) {

				$user->attachRole('3');

				$uProfile = new UserProfile;
				$uProfile->user_id = $user->id;
				$uProfile->fullname = $profile['name'];
				$uProfile->summary = $profile['profile'];
				$uProfile->save();

				$token = JWTAuth::fromUser($user, $customClaims);

				$status = 'success';
				$message = 'Terima kasih atas dukungannya, mohon tunggu kabar selanjutnya melalui email';
			}
			//$user = Auth::user();
            //return response()->json(['token' => $token, 'user' => $user, 'message'=> $message, 'status' => $status]);
            return response()->json(['user' => $user, 'message'=> $message, 'status' => $status]);
        }
    }
    
    public function refresh() {
        $token = JWTAuth::getToken();
        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        } try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return response()->json(['token'=>$token]);
    }
}
