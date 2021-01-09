<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function like(Request $request)
    {
        $userId = Auth::id();
        $like = Like::where(['user_id'=> $userId, 'post_id'=> $request->postId]);
        $likeCount = $like->count();

        if($likeCount == 0) {
        $like = new Like;
        $like->user_id = $request->userId;
        $like->post_id = $request->postId;
        $like->save();
        } else {
            $like->delete();
        }
    }
}
