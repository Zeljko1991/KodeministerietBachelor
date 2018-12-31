@extends('layouts.app')

@section('content')
    <dashboard-wrap :project-case="{{$ProjectCase}}" :all-cases="{{$AllCases}}"></dashboard-wrap>
@endsection
