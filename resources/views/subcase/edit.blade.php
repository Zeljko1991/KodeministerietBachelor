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
                <table id="dynamic_field">
                @if (count($SubCase->deliverables) > 0)
                    {{Form::label('deliverable', 'Deliverable', ['for' => 'deliverable[]'])}}
                    @foreach ($SubCase->deliverables as $Deliverable)
                    <tr id="delivrow{{$Deliverable->id}}">
                        <td>{{Form::text('deliverable[]', $Deliverable->title, ['class' => 'validate', 'id' => 'deliverable deliv'.$Deliverable->id])}}</td>
                        <td><button class="btn" name="add" id="add"><i class="material-icons left">add</i>More deliverables</button></td>
                        <td><button type="button" name="remove" id="'deliv{{$Deliverable->id}}" class="btn red btn_remove">X</button></td>
                    </tr> 
                    @endforeach
                @endif
                </table>
                {{Form::label('price', 'Price', ['for' => 'price'])}}
                <div class="input-field col s12 l6">
                    {{Form::number('price', $SubCase->price, ['id' => 'price','class' => 'validate materialize-textarea'])}}
                </div>
                {{Form::label('status', 'Status', ['for' => 'status'])}}
                <div class="input-field col s12 l6">
                    {{Form::select('status', $CaseStatus, $ProjectCase->case_status_id)}}
                </div>
                {{Form::number('project_case_id', $SubCase->project_case_id, ['hidden'])}}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Submit', ['class' => 'btn btn-large'])}}
            </div>
            {!! Form::close() !!}
        </div>
@endsection

