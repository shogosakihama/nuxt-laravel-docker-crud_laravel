<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
      $user = Auth::id();
      $posts = Post::take(10)
      ->with('like')
      ->get();

      $res = [
          "posts" => $posts->map(function($post) {
              return [
                  "id" => $post->id,
                  "title" => $post->title,
                  "text" => $post->text,
                  "userId" => $post->user_id,
                  "like" => $post->like->map(function($like){
                      return [
                          "id" => $like->id
                      ];
                  })->count(),
                  "like_user" => $post->like->map(function($like){
                    return [
                        "id" => $like->user_id
                    ];
                }),
                "user_check" => $post->like->map(function($like){
                    return [
                        "id" => $like->user_id
                    ];
                }),
              ];
          })->all(),
    ];

      return response()->json(['posts' => $res, 'user' => $user]);
    }

    public function store(Request $request)
    {
      $post = new Post;

      $post->title = $request->title;
      $post->text = $request->text;
      $post->user_id = Auth::id();
      // $post->user_id = $request->user()->id;

      $post->save();
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $post = Post::find($id);

        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = 2;
        // $post->user_id = $request->user()->id;

        $post->save();
    }

    public function destroy(Request $request)
    {
      $id = $request->id;
      $post = Post::find($id);
      $post->delete();
    }
}
