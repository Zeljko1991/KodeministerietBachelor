@extends('layouts.app')

@section('content')
    <div class="card">
            {!! Form::open(['action' => 'SubCaseController@store', 'method' => 'POST']) !!}
            <div class="card-content">
                <span class="card-title">{{$ProjectCase->title}}</span>
                <div class="input-field col s12 l6">
                    {{Form::label('title', 'Title', ['for' => 'textinput1'])}}
                    {{Form::text('title', '', ['class' => 'validate', 'id' => 'textinput1'])}}
                </div>
                <!-- Moved Form::label out of div because of materialize styling -->
                {{Form::label('description', 'Description', ['for' => 'article-ckeditor'])}}
                <div class="input-field col s12 l6">
                    {{Form::textarea('description', '', ['id' => 'article-ckeditor','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('deliverables', 'Deliverables', ['for' => 'deliverables'])}}
                <div class="input-field col s12 l6">
                    {{Form::textarea('deliverables', '', ['id' => 'deliverables','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('price', 'Price', ['for' => 'price'])}}
                <div class="input-field col s12 l6">
                    {{Form::number('price', '', ['id' => 'price','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::number('project_case_id', $ProjectCase->id, ['hidden'])}}
                {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
            </div>
            {!! Form::close() !!}
        </div>
@endsection

