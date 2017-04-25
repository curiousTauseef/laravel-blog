<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all posts
        $posts = Post::orderBy('id', 'desc')->paginate(3);

        return view('posts/index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts/create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $this->validate($request, array(
                'title' => 'required|max:255',
                'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                'category_id' => 'required|integer',

                'body' => 'required'
            ));
        
        //store data
        $post = new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        $post->save();

        $post->tags()->sync($request->tags, false);
        //success message to user
        Session::flash('success', 'The blog post was successfully saved!');

        //redirect user
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts/show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('name', 'id')->toArray();
        $tags = Tag::pluck('name', 'id')->toArray();

        return view('posts/edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate data
        $post = Post::find($id); 

        if ($request->input('slug') == $post->slug) {
            $this->validate($request, array(
                    'title' => 'required|max:255',
                    'body' => 'required',
                    'category_id' => 'required|integer',

                ));
        }

        else {
            $this->validate($request, array(
                    'title' => 'required|max:255',
                    'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                    'category_id' => 'required|integer',
                    'body' => 'required'
                ));
        }

        //save data
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = $request->input('body');
        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags, true);
        }
        else {
            $post->tags()->sync([]);
        }
        
        //flash success message
        Session::flash('success', 'This post was successfully saved.');
        //redirect to show page
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //removes references to tags associated with the post
        $post->tags()->detach();
        
        $post->delete();

        Session::flash('success', 'This post was successfully deleted.');

        return redirect()->route('posts.index');
    }
}
