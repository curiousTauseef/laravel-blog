<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use Session;
use Purifier;
use Image;
use File;

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
                'body' => 'required',
                'image' => 'sometimes|image'
            ));
        
        //store data
        $post = new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800,400)->save($location);

            //define the image url for the post in the database
            $post->image = $filename;
        }

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
        $location = public_path('images/' . $post->image);
        $imageWidth = Image::make($location)->width();
        $imageHeight = Image::make($location)->height();

        return view('posts/show', compact('post', 'imageWidth', 'imageHeight'));
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

            $this->validate($request, array(
                    'title' => 'required|max:255',
                    'slug' => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
                    'category_id' => 'required|integer',
                    'body' => 'required',
                    'image' => 'sometimes|image'
                ));

        //save data
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        if($request->hasFile('image')) {

            //add new image
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800,400)->save($location);

            //get old file name
            $oldfilename = $post->image;
            //update database with new filename
            $post->image = $filename;
            //delete old image
            unlink(public_path('images/' . $oldfilename));

        }

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
        
        unlink(public_path('images/' . $post->image));

        $post->delete();

        Session::flash('success', 'This post was successfully deleted.');

        return redirect()->route('posts.index');
    }
}
