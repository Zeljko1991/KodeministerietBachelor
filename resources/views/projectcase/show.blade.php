@extends('layouts.app')

@section('content')
    <projectcase-show :projectcase="{{$ProjectCase}}" :subcases="{{$SubCases}}" :casestatuses="{{$CaseStatus}}"></projectcase-show>
@endsection
