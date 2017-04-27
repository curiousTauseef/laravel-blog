@extends('main')
<?php $titleTag = htmlspecialchars($post->title); ?>
@section('title', " | $titleTag")

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>{{ $post->title }}</h1>
        @if($post->image)
        <div class="text-center">
            <img class="featured-img" src="{{ asset('images/' . $post->image) }}" height="{{ $imageHeight }}" width="{{ $imageWidth }}">
        </div>
        @endif

        <p class="lead">{!! $post->body !!}</p>
        <hr>
        <p>{{ $post->category->name }}</p>
    </div>
</div>
&nbsp;
<div class="row">
    <div id="comment-form" class="col-md-8 col-md-offset-2">
        {{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('name', 'Name:') }}
                    {{ Form::text('name', null, ['class'=> 'form-control']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('email', 'Email:') }}
                    {{ Form::text('email', null, ['class'=> 'form-control']) }}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('comment', 'Comment:') }}
                    {{ Form::textarea('comment', null, ['class'=> 'form-control', 'rows' => '5']) }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Add comment', ['class' => 'btn btn-success btn-block'])}}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        &nbsp;
        <h2><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comments</h2>
        &nbsp;

        @foreach($post->comments as $comment)
            
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object" src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?d=identicon" }}" alt="{{ $comment->name }} ">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $comment->name }} <small>{{ $comment->created_at->diffForHumans() }}</small></h4> 
                    {{$comment->comment}}
                </div>
            </div>

            @if(!$loop->last)
                <hr>
            @endif

        @endforeach
    </div>
</div>

@endsection
