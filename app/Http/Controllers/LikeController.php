<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Posts $post)
    {
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    public function unlike(Posts $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return back();
    }
}
