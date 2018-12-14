@extends('layouts.app')

@section('content')
<ul class="collection with-header">
    <li class="collection-header"><h4>{{$Customer->firstName}} {{$Customer->lastName}} ID#{{$Customer->id}}</h4></li>
    <li class="collection-item">Email: {{$Customer->eMail}}</li>
    <li class="collection-item">Phone Number: {{$Customer->phoneNumber}}</li>
    <li class="collection-item">CVR: {{$Customer->CVR}}</li>
    <li class="collection-item">EAN: {{$Customer->EAN}}</li>
    <li class="collection-item">
        {!! Form::open(['action' => ['CustomerController@destroy', $Customer->id], 'method' => 'POST', 'pull-right']) !!}
            <a href="/customer/{{$Customer->id}}/edit" class="btn"><i class="left material-icons">add</i>Edit Customer</a>
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn red'])}}
            {!! Form::close() !!}
    </li>
</ul>
@endsection
