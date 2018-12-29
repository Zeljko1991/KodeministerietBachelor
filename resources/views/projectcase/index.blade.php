@extends('layouts.app')

@section('content')
<projectcase-view :projectcases="{{$ProjectCases}}" :customers="{{$Customers}}"></projectcase-view>
@endsection
