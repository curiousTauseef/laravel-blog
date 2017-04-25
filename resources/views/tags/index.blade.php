@extends('main')

@section('title', ' | Tags')

@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>Tags</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            @foreach($tags as $tag)
                <tr>
                    <th>{{$tag->id}}</th>
                    <td>{{$tag->name}}</td>
                    <td>
                        <a href="{{ route('tags.edit', $tag->id )}}" class="btn btn-default btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-md-3 col-md-offset-1">
        <div class="well">
            {!! Form::open(['route' => 'tags.store']) !!}
                <h2>New Tag</h2>

                <div class="form-group">
                    {{ Form::label('name', 'Name:') }}
                    {{ Form::text('name', null, ['class'=> 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Add Tag', ['class' => 'btn btn-primary btn-block']) }}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



@endsection