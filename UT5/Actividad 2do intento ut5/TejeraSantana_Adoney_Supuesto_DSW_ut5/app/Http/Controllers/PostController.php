<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();

        return new PostCollection($posts->loadMissing("usuario")->loadMissing("categoria"));
    }

    public function store(StorePostRequest $request) {
        $nuevoPost = new Post($request->all());
        $nuevoPost->save();

        return new PostResource($nuevoPost->loadMissing("usuario")->loadMissing("categoria"));
    }

    public function update(UpdatePostRequest $request, $postId) {
        $post = Post::find($postId);

        if ($post) {
            $post->update($request->all());

            return new PostResource($post->loadMissing("usuario")->loadMissing("categoria"));

        } else {
            return response(false, 500);
        }
    }

    public function destroy($postId) {
        $post = Post::find($postId);

        if ($post) {
            $post->delete();

            return response(true);

        } else {
            return response(false, 500);
        }
    }

    public function show($postId) {
        $post = Post::find($postId);

        if ($post) {
            return new PostResource($post->loadMissing("usuario")->loadMissing("categoria"));

        } else {
            return response(false, 500);
        }

    }
}
