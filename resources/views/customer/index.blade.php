@extends('layouts.app')

@section('content')
    <div class="row center">
        <div class="card center col s12">
            <div class="card-content">
                <a href="/customer/create" class="waves-effect waves-light btn-large"><i class="left material-icons">add</i>Create Customer</a>
            </div>
        </div>
    </div>
    <ul class="collapsible popout">
            @if (count($Customers) > 0)
                @foreach ($Customers as $Customer)
                <li>
                    <div class="collapsible-header customHover">
                        <div class="row">
                            <div class="col s12"><strong>{{$Customer->firstName}} {{$Customer->lastName}}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col s12"><strong>{{$Customer->phoneNumber}}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col s12"><strong>{{$Customer->eMail}}</strong></div>
                        </div>
                    </div>
                    <div class="collapsible-body">
                        <ul class="collection">
                            <li class="collection-item">Customer ID <h5>{{$Customer->id}}</h5></li>
                            <li class="collection-item">CVR <h5>{{$Customer->CVR}}</h5></li>
                            <li class="collection-item">EAN <h5>{{$Customer->EAN}}</h5></li>
                            <li class="collection-item">Street & Number <h5>{{$Customer->Address->street}} {{$Customer->Address->streetNumber}}</h5></li>
                            <li class="collection-item">Zip Code <h5>{{$Customer->Address->zipCode}}</h5></li>
                            <li class="collection-item">City & Country <h5>{{$Customer->Address->city}}, {{$Customer->Address->country}}</h5></li>
                            <li class="collection-item center"><a href="/customer/{{$Customer->id}}/edit" class="btn btn-large">Edit {{$Customer->firstName}} {{$Customer->lastName}}</a></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            @else
                <li>
                    <div class="collapsible-header"><strong>Sorry but you seem to have no customers!</strong></div>
                </li>
            @endif

    </ul>



@endsection
