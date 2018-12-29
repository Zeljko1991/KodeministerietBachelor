@extends('layouts.app')

@section('content')
    <projectcase-show :projectcase="{{$ProjectCase}}" :subcases="{{$SubCases}}"></projectcase-show>
@endsection
