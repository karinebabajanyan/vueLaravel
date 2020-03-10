<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $isAdmin=$auth->isAdmin();
        $users=User::where('id','!=' ,$auth->id)->get();
        return response()->json(['users' => $users,'auth'=>$auth,'isAdmin'=>$isAdmin], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userModel=new User;
        User::create($request->only($userModel->getFillable()));
        return response()->json([
            'message' => 'Success'
        ], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userModel=new User;
        $user=User::find($id)->update($request->only($userModel->getFillable()));
        dd($request->only($userModel->getFillable()));
        //
        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user=User::find($id);
        if($user->delete()) {
            $posts=$user->posts;
            if($posts){
                foreach ($posts as $key => $post) {
                    $images=$post->files;
                    if($images){
                        foreach ($images as $k => $image) {
                            $image->delete();
                        }
                    }
                    $post->delete();
                }
            }
        }
        return response()->json([
            'message' => 'Success'
        ], 200);
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
}
