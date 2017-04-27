@extends('main')

@section('title', " | $post->title")

@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>{{ $post->title }}</h1>
        <p class="lead">{!! $post->body !!}</p>
        <hr>
        <div class="tags">
            @foreach($post->tags as $tag)
                <span class="label label-default">{{$tag->name}}</span>
            @endforeach
        </div>

        <div class="">
            <h3>Comments <small>{{ $post->comments->count() }}</small></h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($post->comments as $comment)
                    <tr>
                        <td>{{ $comment->name }}</td>
                        <td>{{ $comment->email }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>

                        {!! Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE', 'style' => 'display: inline' ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash">', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit']) !!}
                        {!! Form::close() !!}

                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></a></span>
                            {{-- <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></a></span> --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
