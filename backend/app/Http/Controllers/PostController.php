<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
      $post = new Post;

      $post->title = $request->title;
      $post->text = $request->text;
      $post->user_id = 2;
      // $post->user_id = $request->user()->id;

      $post->save();
    }
}
