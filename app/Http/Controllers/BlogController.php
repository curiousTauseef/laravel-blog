<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use Carbon\Carbon;
use Image;

class BlogController extends Controller
{

    public function getIndex() {
        $posts = Post::paginate(10);

        return view('blog/index')->with(compact('posts'));
    }

    public function getSingle($slug) {

        //where returns collection, so use first instead of get to return single post object instead of collection of nested objects.
        $post = Post::where('slug', '=', $slug)->first();
        $location = public_path('images/' . $post->image);
        $imageWidth = Image::make($location)->width();
        $imageHeight = Image::make($location)->height();


        return view('blog/single', compact('post', 'imageWidth', 'imageHeight'));
    }
}
