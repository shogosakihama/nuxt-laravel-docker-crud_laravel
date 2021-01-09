<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    public function like()
    {
      return $this->hasMany(Like::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function is_liked_by_auth_user()
    {
      $id = Auth::id();

      $likers = array();
      foreach($this->like as $like) {
        array_push($likers, $like->user_id);
      }

      if (in_array($id, $likers)) {
        return true;
      } else {
        return false;
      }
    }

    public function is_auth_user()
    {
      $id = Auth::id();

      $postUser = array();
      foreach($this->user->post as $post) {
        array_push($postUser, $post->user_id);
      }

      if (in_array($id, $postUser)) {
        return true;
      } else {
        return false;
      }
    }
}
