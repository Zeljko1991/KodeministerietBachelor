@extends('layouts.app')

@section('content')
    <div class="row center">
        <div class="card center col s12">
            <div class="card-content">
                <a href="/customer/create" class="waves-effect waves-light btn-large"><i class="left material-icons">add</i>Create Customer</a>
            </div>
        </div>
    </div>

    <div class="row center">
        <div class="col s4"><h5>Name</h5></div>
        <div class="col s4"><h5>Phone</h5></div>
        <div class="col s4"><h5>Email</h5></div>
    </div>
    <ul class="collapsible">
            @if (count($Customers) > 0)
                @foreach ($Customers as $Customer)
                <li>
                    <div class="collapsible-header hoverable">
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
                            <li class="collection-item">Customer ID {{$Customer->id}}</li>
                            <li class="collection-item">CVR {{$Customer->CVR}}</li>
                            <li class="collection-item">EAN {{$Customer->EAN}}</li>
                            <li class="collection-item">Address ID {{$Customer->address_id}}</li>
                            <li class="collection-item">Street & Number {{$Customer->Address->street}} {{$Customer->Address->streetNumber}}</li>
                            <li class="collection-item">Zip Code {{$Customer->Address->zipCode}}</li>
                            <li class="collection-item">City & Country {{$Customer->Address->city}} {{$Customer->Address->country}}</li>
                            <li class="collection-item center"><a href="/customer/{{$Customer->id}}/edit" class="btn">Edit {{$Customer->firstName}} {{$Customer->lastName}}</a></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            @else
                <li>
                    <div class="collapsible-header"><strong>There are no subcases for this case</strong></div>
                </li>
            @endif

    </ul>



@endsection
