<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('site.posts.index', [
            'posts' => Post::where('status', 'published')->latest('publish_at')->paginate(9),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $post->increment('views');

        return view('site.posts.show', ['post' => $post]);
    }
}
