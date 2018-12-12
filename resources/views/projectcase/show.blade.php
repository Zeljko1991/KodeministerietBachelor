@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-content">
        <span class="card-title">{{$ProjectCase->title}}</span>
            <div>{!!$ProjectCase->description!!}</div>
            <small>{{$ProjectCase->created_at}}</small>
            <div class="card-action">
                <a href="/subcase/create/{{$ProjectCase->id}}" class="btn"><i class="left material-icons">add</i>Create Subcase</a>
                <a href="/projectcase/{{$ProjectCase->id}}/edit" class="btn">Edit</a>
                {!!Form::open(['action' => ['ProjectCaseController@destroy', $ProjectCase->id], 'method' => 'POST', 'class'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn red'])}}
                {!!Form::close()!!}
            </div>
    </div>
</div>

<ul class="collapsible">
    @foreach ($SubCases as $SubCase)
    <li>
        <div class="collapsible-header">{{$SubCase->title}}</div>
        <div class="collapsible-body">
            <div class="row">
                {!!$SubCase->description!!}
            </div>
            <div class="row">
                {!!$SubCase->deliverables!!}
            </div>
        </div>
    </li>
    @endforeach
</ul>
@endsection
