<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class BlogController extends Controller
{

    public function getIndex() {
        $posts = Post::paginate(10);

        return view('blog/index')->with(compact('posts'));
    }

    public function getSingle($slug) {

        //where returns collection, so use first instead of get to return single post object instead of collection of nested objects.
        $post = Post::where('slug', '=', $slug)->first();

        return view('blog/single')->withPost($post);
    }
}
