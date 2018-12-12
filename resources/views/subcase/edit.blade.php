@extends('layouts.app')

@section('content')
    <div class="card">
            {!! Form::open(['action' => ['SubCaseController@update', $SubCase->id], 'method' => 'POST']) !!}
            <div class="card-content">
            <span class="card-title">Subcase: <strong>{{$SubCase->title}}</strong> from case: <strong>{{$ProjectCase->title}}</strong></span>
                <div class="input-field col s12 l6">
                    {{Form::label('title', 'Title', ['for' => 'textinput1'])}}
                    {{Form::text('title', $SubCase->title, ['class' => 'validate', 'id' => 'textinput1'])}}
                </div>
                <!-- Moved Form::label out of div because of materialize styling -->
                {{Form::label('description', 'Description', ['for' => 'article-ckeditor'])}}
                <div class="input-field col s12 l6">
                    {{Form::textarea('description', $SubCase->description, ['id' => 'article-ckeditor','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('deliverables', 'Deliverables', ['for' => 'deliverables'])}}
                <div class="input-field col s12 l6">
                    {{Form::textarea('deliverables', $SubCase->deliverables, ['id' => 'deliverables','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('price', 'Price', ['for' => 'price'])}}
                <div class="input-field col s12 l6">
                    {{Form::number('price', $SubCase->price, ['id' => 'price','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::number('project_case_id', $SubCase->project_case_id, ['hidden'])}}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
            </div>
            {!! Form::close() !!}
        </div>
@endsection

