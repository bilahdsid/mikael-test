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
            $id = $user->posts()->create($data);
            return $this->successResponse($id,'success');

        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdatePostRequest $request){

        $data = $request->validated();
        $user = $request->user();

        try{
            $post = Post::findOrfail($request->post_id);
            if ($user->can('update', $post)) {
                $id = $post->update($data);
                return $this->successResponse($id,'success');
            }else{
                return $this->errorResponse('Not allowed');
            }

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


    public function delete(Request $request){

        $user = $request->user();

        try{
            $post = Post::findOrfail($request->post_id);
            if ($user->can('delete', $post)) {
                $id = $post->delete();
                return $this->successResponse($id,'success');
            }else{
                return $this->errorResponse('Not allowed');
            }
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }


    }
}
