<?php

namespace App\Http\Controllers;
use App\File;
use App\Http\Services\FileService;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPosts = Post::with('files')->get();
        $myPosts=auth()->user()->posts()->with('files')->get();
        return response()->json(['allPosts' => $allPosts,'myPosts'=>$myPosts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FileService $fileService)
    {
        $id=auth()->id();
        $uploadedFiles=$request->pics;

        $post=Post::create([
                "title"=>$request->title,
                "description"=>$request->description,
                "user_id"=>$id,
            ]
        );
        foreach ($uploadedFiles as $key => $file){
            $category=null;
            if($request->checked==$key){
                $category ='checked';
            }
            $fileService->saveFile($file, $post, $category);
        }
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
        $post = Post::with('files')->find($id);
        return response()->json(['post' => $post], 200);
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
        dd($request->all());
        return response()->json([
            'message' => $request->title
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$category)
    {
        if($category==='files'){
            File::find($id)->delete();
        }
        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
//       dd($id);
    }
}
