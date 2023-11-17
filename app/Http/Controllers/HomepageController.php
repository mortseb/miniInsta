<?php

namespace App\Http\Controllers;

use App\Models\Posts;

class HomepageController extends Controller
{
    public function index()
    {
        $posts = Posts::paginate(12);
        return view('homepage.index', [
            'posts' => $posts,
        ]);
    }
}

