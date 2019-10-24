<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\AddLikeRequest;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function add(AddPostRequest $request){

        $data = $request->validated();

        $user = $request->user();

        try{

            $id = $user->posts()->firstOrCreate($data);
            return $this->successResponse($id,'success');

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdatePostRequest $request){

        $data = $request->validated();
        unset($data['post_id']);
        $user = $request->user();

        try{

            $id = Post::updateOrCreate(['id'=>$request->post_id,'user_id'=>$user->id],$data);
            //$id = $user->posts()->find($request->post_id)->update($data);
            return $this->successResponse($id,'success');

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request){

        $posts = Post::with(['likes','comments' => function ($query) {
            $query->select('body');
        }])->paginate();

        return $this->successResponse($posts,'success');

    }

    public function like(AddLikeRequest $request){

        $data = $request->validated();

        $user = $request->user();

        try{

            $id = Post::find($request->post_id)->likes()->attach($user->id);
            return $this->successResponse($id,'success');

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function comment(AddCommentRequest $request){

        $data = $request->validated();

        $user = $request->user();

        try{
            $id = Post::find($request->post_id)->comments()->attach($user->id,['body'=>$request->body]);

            return $this->successResponse($id,'success');

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
