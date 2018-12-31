@extends('layouts.app')

@section('content')
    <projectcase-view :projectcases="{{$ProjectCases}}" :customers="{{$Customers}}" :stages="{{$CaseStatus}}"></projectcase-view>
@endsection
