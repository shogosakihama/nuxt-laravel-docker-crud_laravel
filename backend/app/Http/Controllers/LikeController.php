<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function like(Request $request)
    {
        $like = new Like;
        $like->user_id = $request->userId;
        $like->post_id = $request->postId;
        $like->save();

      session()->flash('success', 'You Liked the Reply.');

    }
}
