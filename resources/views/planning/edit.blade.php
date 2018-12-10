@extends('layouts.app')

@section('content')
<div class="card">
    {!! Form::open(['action' => ['PlanningController@update', $ProjectCase->id], 'method' => 'POST']) !!}
    <div class="card-content">
        <div class="input-field col s12 l6">
            {{Form::label('title', 'Title', ['for' => 'textinput1'])}}
            {{Form::text('title', $ProjectCase->title, ['class' => 'validate', 'id' => 'textinput1'])}}
        </div>
        <!-- Moved Form::label out of div because of materialize styling -->
        {{Form::label('description', 'Description', ['for' => 'article-ckeditor'])}}
        <div class="input-field col s12 l6">
            {{Form::textarea('description', $ProjectCase->description, ['id' => 'article-ckeditor','class' => 'validate materialize-textarea'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
    </div>
    {!! Form::close() !!}
</div>
@endsection
