<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsStoreRequest;
use App\Models\Comment;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des posts des utilisateurs suivis avec les informations de l'utilisateur
        $followingPosts = Posts::with('user')
            ->withCount('likes') // Ajoutez cette ligne
            ->whereHas('user.followers', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest('published_at')
            ->paginate(12);

        $popularPosts = Posts::with('user')
            ->withCount('likes') // Et ici aussi
            ->orderBy('likes_count', 'desc')
            ->paginate(12);


        return view('posts.index', [
            'followingPosts' => $followingPosts,
            'popularPosts' => $popularPosts,
        ]);
    }


    public function show($id)
    {
        $posts = Posts::findOrFail($id);
        $comments = $posts
            ->comments()
            ->with('user')
            ->orderBy('created_at')
            ->get();
        return view('posts.show', [
            'posts' => $posts,
            'comments' => $comments,

        ]);
    }
    public function create()
    {
        return view('dashboard');
    }
    public function store(PostsStoreRequest $request)
    {
        $posts = Posts::make();
        $path = $request->file('image')->store('images', 'public');
        $posts->img_path = $path;
        $posts->body = $request->validated()['body'];
        $posts->published_at = now();
        $posts->user_id = Auth::id();
        $posts->save();

        return redirect()->route('posts.index');
    }
    public function addComment(Request $request, Posts $posts)
    {
        // On vérifie que l'utilisateur est authentifié
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        // On crée le commentaire
        $comment = $posts->comments()->make();
        $comment->body = $request->input('body');
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return redirect()->back();
    }
    public function deleteComment(Posts $posts, Comment $comment)
    {
        // On vérifie que l'utilisateur à le droit de supprimer le commentaire
        $this->authorize('delete', $comment);

        // On supprime le commentaire
        $comment->delete();

        // On redirige vers la page de l'article
        return redirect()->back();
    }
}
