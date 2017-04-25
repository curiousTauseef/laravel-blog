@extends('main')

@section('title', '| Create New Post')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Create New Post</h1>
        <hr>
        {!! Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '')) !!}
        
            <div class="form-group">
                {{ Form::label('title', 'Title:') }}
                {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}
            </div>

            <div class="form-group">
                {{ Form::label('slug', 'Slug:') }}
                {{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255')) }}
            </div>

            <div class="form-group">
                {{ Form::label('category_id', 'Category:') }}
                <select name="category_id" class="form-control">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {{ Form::label('body', "Post Body:") }}
                {{ Form::textarea('body', null, array('class'=>'form-control', 'required' => '')) }}
            </div>
                {{ Form::submit('Create Post', array('class' => 'btn btn-success'))}}                
        {!! Form::close() !!}
        </form>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection