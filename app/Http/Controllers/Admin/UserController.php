<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Redirect;

class UserController extends Controller
{

    public function __construct()
    {
        /*if($this->middleware('auth')){
            
            return Redirect('/auth/login');
        }*/


        /*only spesific
        ===============================*/
        // $this->middleware('auth', ['only' => 'create']);
        // ===============================

        $this->middleware('auth');

        // $this->middleware('role:admin');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest('created_at')->get();


        return view('admin.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.createUser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // User::create($request::all());
        $input = $request->all();

        $input['level_id'] = 2;

        // return $input;

        User::create($input);

        return Redirect::back()->with('flash_message', 'User has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // dd($user->created_at->addDays(9)->diffForHumans());

        return view('admin.user.user')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.editUser')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $input = $request->all();

        // return $input;

        $user->update($input);

        return Redirect::back()->with('flash_message', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // dd($user->name);
        User::findOrFail($id)->delete();

        return Redirect::back()->with('flash_message', 'User "'.$user->name.'" has been deleted');
    }
}
