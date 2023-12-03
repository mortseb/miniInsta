<?php

namespace App\Http\Controllers;

use App\Models\Posts;

class HomepageController extends Controller
{
    public function index()
    {
        $posts = Posts::where('published_at', '<', now())
            ->withCount('comments')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();
        if (auth()->check()) {
            return redirect("posts");
        }
        return view('homepage.index', [
            'posts' => $posts,
        ]);
    }
}
