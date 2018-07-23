<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\User;
use App\UserContact;
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
    public function addContact($contact_id) {

        $input['user_id'] = Auth::user()->id;
        
        $input['contact_id'] = $contact_id;

        $contact = UserContact::create($input);
        if($contact) {
            $params = [
                'status' => "success",
                'message' => "berhasil ditambahkan",
            ];
        }

		return response()->json($params, 200);

    }

    public function removeContact($contact_id) {
        $user_id = Auth::user()->id;

        $delete = UserContact::where([
			'user_id'	=> $user_id,
			'contact_id'=> $contact_id])
			->delete();
		if ($delete) {
			$params = [
				'status' => "success",
				'message' => "Kontak dihapus",
			];
		}
        
		return response()->json($params, 200);
    }
}
