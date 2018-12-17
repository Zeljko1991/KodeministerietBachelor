@extends('layouts.app')

@section('content')
<h1>Plan for subcase: {{$SubCase->title}}</h1>
    <kanban-board :deliverables-todo="{{$DeliverablesTodo}}" :deliverables-doing="{{$DeliverablesDoing}}" :deliverables-done="{{$DeliverablesDone}}" :subcase="{{$SubCase->id}}"></kanban-board>
@endsection
