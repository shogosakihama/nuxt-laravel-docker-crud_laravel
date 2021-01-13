<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:sanctum')->except('indexNoauth');
    }

    public function index(Request $request)
    {
      $user = Auth::id();
      $posts = Post::take(10)
      ->with('like')
      ->orderBy('id', 'desc')
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
                "user_check" => $post->is_liked_by_auth_user(),
                "auther_check" => $post->is_auth_user(),
              ];
          })->all(),
    ];

      return response()->json(['posts' => $res, 'user' => $user]);
    }

    public function indexNoauth(Request $request)
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
                "user_check" => $post->is_liked_by_auth_user(),
              ];
          })->all(),
    ];

      return response()->json(['posts' => $res, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $item = DB::transaction(function () use ($request) {

        $post = new Post;

        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = Auth::id();
        // $post->user_id = $request->user()->id;

        $post->save();
        });

    }



    public function update(Request $request)
    {
        $item = DB::transaction(function () use ($request) {

        $id = $request->id;
        $post = Post::find($id);

        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = Auth::id();

        $post->update();
        });

    }

    public function destroy(Request $request)
    {
      $id = $request->id;
      $post = Post::find($id);
      $post->delete();
    }
    public function userDelete(Request $request)
    {
        $user = Auth::id();
        User::findOrFail($user)->delete();

        return response()->json(['message' => 'userDeleted']);
    }
}
