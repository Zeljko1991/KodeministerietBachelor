@extends('layouts.app')

@section('content')
<div class="card ">
    <div class="card-content">
        <span class="card-title">{{$ProjectCase->title}}</span>
            <p>{{$ProjectCase->description}}</p>
            <small>{{$ProjectCase->created_at}}</small>
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
