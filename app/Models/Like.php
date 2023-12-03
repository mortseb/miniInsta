<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'posts_id'];

    public function post()
    {
        return $this->belongsTo(Posts::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
