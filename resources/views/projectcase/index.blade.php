@extends('layouts.app')

@section('content')
<div class="card">
    {!! Form::open(['action' => 'ProjectCaseController@store', 'method' => 'POST']) !!}
    <div class="card-content">
        <div class="input-field col s12 l6">
            {{Form::label('title', 'Title', ['for' => 'textinput1'])}}
            {{Form::text('title', '', ['class' => 'validate', 'id' => 'textinput1'])}}
        </div>
        <div class="input-field col s12 l6">
            {{Form::label('description', 'Body', ['for' => 'textarea1'])}}
            {{Form::textarea('description', '', ['class' => 'validate materialize-textarea', 'id' => 'textarea1'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
    </div>
    {!! Form::close() !!}
</div>
@endsection
