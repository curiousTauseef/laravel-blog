@extends('main')

@section('title', ' | Edit Tag')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' =>'PUT']) !!}
            <h2>Edit Tag</h2>

            <div class="form-group">
                {{ Form::label('name', 'Name:') }}
                {{ Form::text('name', null, ['class'=> 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Update Tag', ['class' => 'btn btn-success']) }}
            </div>
        {!! Form::close() !!}
        <div class="form-group">
            {!! Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'DELETE']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection