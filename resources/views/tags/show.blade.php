@extends('main')

@section('title', " | $tag->name Tag")

@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>{{ $tag->name }} Tag <small>{{ $tag->posts->count() }} Post{{ $tag->posts->count() > 1 ? 's' : '' }}</small></h1> 
    </div>
    <div class="col-md-4">
        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-lg btn-primary pull-right btn-h1-spacing">Edit</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tag->posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
                    <td>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag->id) }}"><span class="label label-default">{{ $tag->name }}</span></a>
                        @endforeach
                    </td>
                    <td><a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-xs">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection
