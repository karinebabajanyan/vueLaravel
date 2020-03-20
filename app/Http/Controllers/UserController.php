<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FileService;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        try{
            $auth=auth()->user();
            $isAdmin=$auth->isAdmin();
            $users=User::where('id','!=' ,$auth->id)->get();
            return response()->json([
                'users' => $users,
                'auth'=>$auth,
                'isAdmin'=>$isAdmin
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);

            // Commit Transaction
            DB::commit();

            return response()->json([
                'message' => 'Success'
            ], 200);
        }catch (\Exception $exception){

            // Rollback Transaction
            DB::rollback();

            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
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
        // Begin Transaction
        DB::beginTransaction();

        try {
            $data = ['name' => $request->name, 'email' => $request->email,];
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            User::find($id)->update($data);

            // Commit Transaction
            DB::commit();

            return response()->json([
                'message' => 'Success'
            ], 200);
        }catch (\Exception $exception){

            // Rollback Transaction
            DB::rollback();

            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $user = User::find($id);
            if ($user->delete()) {
                $posts = $user->posts;
                $cover = $user->cover_image;
                if ($cover) {
                    $cover->delete();
                }
                if ($posts) {
                    foreach ($posts as $key => $post) {
                        $images = $post->files;
                        if ($images) {
                            foreach ($images as $k => $image) {
                                $image->delete();
                            }
                        }
                        $post->delete();
                    }
                }
            }

            // Commit Transaction
            DB::commit();

            return response()->json([
                'message' => 'Success'
            ], 200);
        }catch (\Exception $exception){

            // Rollback Transaction
            DB::rollback();

            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Display the logged user.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        try {
            $user = auth()->user();
            $cover = $user->cover_image;
            $isAdmin = $user->isAdmin();
            return response()->json([
                'user' => $user,
                'cover' => $cover,
                'isAdmin' => $isAdmin
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }
    /**
     * Update the Profile Image in storage.
     *
     * @param  UserUpdateProfileImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(Request $request, FileService $fileService)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $image = $request->avatar;
            $user = auth()->user();
            $imageExists = $user->cover_image;
            if ($imageExists) {
                $imageExists->delete();
            }
            $fileService->saveFile($image, $user, 'cover');

            // Commit Transaction
            DB::commit();

            return response()->json([
                'message' => 'Success'
            ], 200);
        }catch (\Exception $exception){

            // Rollback Transaction
            DB::rollback();

            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }
}
