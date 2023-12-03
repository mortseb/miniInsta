<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        Auth::user()->following()->create([
            'followed_user_id' => $user->id,
        ]);

        return back();
    }

    public function unfollow(User $user)
    {
        Auth::user()->following()->where('followed_user_id', $user->id)->delete();

        return back();
    }
}
