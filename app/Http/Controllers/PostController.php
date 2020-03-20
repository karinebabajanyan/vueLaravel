<?php

namespace App\Http\Controllers;
use App\File;
use App\Http\Services\FileService;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\Posts\PostStoreRequest;
use App\Http\Requests\Posts\PostUpdateRequest;
use App\Http\Requests\Posts\PostEditRequest;
use App\Http\Requests\Posts\PostShowRequest;
use App\Http\Requests\Posts\PostDestroyRequest;
use App\Http\Requests\Posts\PostDeleteImageRequest;
use App\Http\Requests\Posts\PostSoftDeleteShowRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allPosts = Post::with('files')->get();
            $myPosts = auth()->user()->posts()->with('files')->get();
            return response()->json([
                'allPosts' => $allPosts,
                'myPosts' => $myPosts
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
    public function store(PostStoreRequest $request, FileService $fileService)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $id = auth()->id();
            $uploadedFiles = $request->pics;

            $post = Post::create([
                    "title" => $request->title,
                    "description" => $request->description,
                    "user_id" => $id,
                ]
            );
            foreach ($uploadedFiles as $key => $file) {
                $category = null;
                if ($request->checked == $key) {
                    $category = 'checked';
                }
                $fileService->saveFile($file, $post, $category);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,PostShowRequest $request)
    {
        try {
            $post = Post::with('files')->find($id);
            $update = auth()->user()->can('update', $post);
            $delete = auth()->user()->can('delete', $post);
            $slide='';
            foreach ($post->files as $key=>$value){
                if($value->category==='checked'){
                    $slide=$key;
                }
            }
            return response()->json([
                'post' => $post,
                'update' => $update,
                'delete' => $delete,
                'slide'=>$slide,
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id, FileService $fileService)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $post = Post::with('files')->find($id);
            $post->update([
                'title' => $request->title,
                'description' => $request->description
            ]);
            $file = $post->files;
            if ($file->where('category', 'checked')->first()) {
                $file->where('category', 'checked')->first()->update(['category' => NULL]);
            }
            if (strpos($request->checked, 'old') === false) {
                foreach ($request->pictures as $key => $files) {
                    $category = null;
                    if ((int)$request->checked == $key) {
                        $category = 'checked';
                    }
                    $fileService->saveFile($files, $post, $category);
                }
            } else {
                if ($request->pictures) {
                    foreach ($request->pictures as $key => $files) {
                        $category = null;
                        $fileService->saveFile($files, $post, $category);
                    }
                }
                $fileId = (int)preg_replace("/[^0-9\.]/", '', $request->checked);
                $file->find($fileId)->update(['category' => 'checked']);
            }

            // Commit Transaction
            DB::commit();

            return response()->json([
                'message' => 'Updated successfully'
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
    public function destroy($id,PostDestroyRequest $request)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $post = Post::find($id);
            if ($post) {
                if ($post->files) {
                    foreach ($post->files as $key => $file) {
                        $file->delete();
                    }
                }
                $post->delete();
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
     * Remove the specified image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id,PostDeleteImageRequest $request)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            File::find($id)->delete();

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
