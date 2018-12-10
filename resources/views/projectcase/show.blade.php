@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-content">
        <span class="card-title">{{$ProjectCase->title}}</span>
            <div>{!!$ProjectCase->description!!}</div>
            <small>{{$ProjectCase->created_at}}</small>
            <hr>
            <a href="/projectcase/{{$ProjectCase->id}}/edit" class="btn">Edit</a>
            {!!Form::open(['action' => ['ProjectCaseController@destroy', $ProjectCase->id], 'method' => 'POST', 'class'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn red'])}}
            {!!Form::close()!!}
    </div>
</div>

<ul class="collapsible">
    <li>
      <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
  </ul>
@endsection
