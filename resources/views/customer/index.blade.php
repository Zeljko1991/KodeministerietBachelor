@extends('layouts.app')

@section('content')
    <customer-view :customers="{{$Customers}}"></customer-view>
@endsection
