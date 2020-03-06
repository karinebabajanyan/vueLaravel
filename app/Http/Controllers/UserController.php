<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Services\FileService;
use Auth;
use App\User;
use App\File;
use App\SocialIdentity;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Requests\Users\UserUpdateProfileImageRequest;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserEditRequest;
use App\Http\Requests\Users\UserDestroyRequest;
use App\Http\Requests\Users\UserShowRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=auth()->user();
        $users=User::where('id','!=' ,$auth->id)->get();
        return response()->json(['users' => $users,'auth'=>$auth], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UserCreateRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

    }

    /**
     * Display the specified user.
     *
     * @param  UserShowRequest $request
     * @return \Illuminate\Http\Response
     */
    public function user(UserShowRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Display the logged user.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user=auth()->user();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user,UserEditRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserDestroyRequest $request)
    {
       //
    }
}
