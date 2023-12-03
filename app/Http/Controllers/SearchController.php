<?php

namespace App\Http\Controllers;


use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');

        // Recherche des utilisateurs
        $users = User::where('name', 'like', '%' . $query . '%')->limit(5)->get();

        // Recherche des posts
        $posts = Posts::where('body', 'like', '%' . $query . '%')->limit(5)->get();

        return response()->json([
            'users' => $users,
            'posts' => $posts
        ]);
    }
}
