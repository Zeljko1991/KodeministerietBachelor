@extends('layouts.app')

@section('content')
    <div class="card">
            {!! Form::open(['action' => 'SubCaseController@store', 'method' => 'POST']) !!}
            <div class="card-content">
                <span class="card-title">Create subcase for: <strong>{{$ProjectCase->title}}</strong></span>
                <div class="input-field col s12 l6">
                    {{Form::label('title', 'Title', ['for' => 'textinput1'])}}
                    {{Form::text('title', '', ['class' => 'validate', 'id' => 'textinput1'])}}
                </div>
                <!-- Moved Form::label out of div because of materialize styling -->
                {{Form::label('description', 'Description', ['for' => 'article-ckeditor'])}}
                <div class="input-field col s12 l6">
                    {{Form::textarea('description', '', ['id' => 'article-ckeditor','class' => 'validate materialize-textarea'])}}
                </div>
                <table id="dynamic_field">
                        {{Form::label('deliverable', 'Deliverable', ['for' => 'deliverable[]'])}}
                    <tr>
                       <td>{{Form::text('deliverable[]', '', ['class' => 'validate', 'id' => 'deliverable'])}}</td>
                       <td><button class="btn" name="add" id="add"><i class="material-icons left">add</i>More deliverables</button></td>
                    </tr> 
                </table>
                {{Form::label('price', 'Price', ['for' => 'price'])}}
                <div class="input-field col s12 l6">
                    {{Form::number('price', '', ['id' => 'price','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('status', 'Status', ['for' => 'status'])}}
                <div class="input-field col s12 l6">
                    {{Form::select('status', $CaseStatus, ['id' => 'status'])}}
                </div>
                {{Form::number('project_case_id', $ProjectCase->id, ['hidden'])}}
                {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
            </div>
            {!! Form::close() !!}
        </div>
@endsection

