@extends('main')

@section('title', " | $post->title")

@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>{{ $post->title }}</h1>
        <p class="lead">{{ $post->body }}</p>
    </div>

    <div class="col-md-4">
        <div class="well">
            <p class="text-center"><a href="{{ route('blog.single', $post->slug) }}">{{ route('blog.single', $post->slug) }}</a></p>
            <dl class="dl-horizontal">
                <dt>Created At: </dt>
                <dd>{{ date('M j, Y h:ia', strtotime($post->created_at)) }}</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Last Updated: </dt>
                <dd>{{ date('M j, Y h:ia', strtotime($post->updated_at)) }}</dd>
            </dl>

            <p class="text-center">{{ $post->category->name }}</a></p>

            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Html::linkRoute('posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                    {!! Form::close() !!}
                </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {{Html::linkRoute('posts.index', "<< See All Posts", [], ['class' => 'btn btn-default btn-block'] )}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
