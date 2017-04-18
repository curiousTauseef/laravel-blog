@extends('main')

@section('title', ' | Edit Post')

@section('content')

<div class="row">
    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT']) !!}
    <div class="col-md-8">
        <div class="form-group">
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', null, ['class' => 'form-control input-lg']) }}
        </div>

        <div class="form-group">
            {{ Form::label('slug', 'Slug:') }}
            {{ Form::text('slug', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('body', 'Body:') }}
            {{ Form::textarea('body', null, ['class' => 'form-control']) }}
        </div>
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
            <hr>
            <div class="row">
                <div class="col-sm-6">
                {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-primary btn-block')) !!}
                </div>
                <div class="col-sm-6">
                {{ Form::submit('Save', ['class' =>"btn btn-success btn-block"]) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection
