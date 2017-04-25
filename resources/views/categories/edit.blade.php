@extends('main')

@section('title', ' | Edit Category')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' =>'PUT']) !!}
            <h2>Edit Category</h2>

            <div class="form-group">
                {{ Form::label('name', 'Name:') }}
                {{ Form::text('name', null, ['class'=> 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Update Category', ['class' => 'btn btn-success']) }}
            </div>
        {!! Form::close() !!}
        <div class="form-group">
            {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection