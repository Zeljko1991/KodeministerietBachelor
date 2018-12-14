@extends('layouts.app')

@section('content')
    <h1>Edit {{$Customer->firstName}} {{$Customer->lastName}}</h1>
    <div class="row">
        <div class="card">
            <div class="row">
                {!!Form::open(['action' => ['CustomerController@update', $Customer->id], 'method' => 'POST', 'class' => 'col s12'])!!}
                <div class="card-content">
                    <span class="card-title">New</span>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('firstName', 'First Name', ['for' => 'firstName'])}}
                            {{Form::text('firstName', $Customer->firstName, ['class' => 'validate', 'id' => 'firstName'])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('lastName', 'Last Name', ['for' => 'lastName'])}}
                            {{Form::text('lastName', $Customer->lastName, ['class' => 'validate', 'id' => 'lastName'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('eMail','Email', ['for' => 'email'])}}
                            {{Form::text('eMail', $Customer->eMail, ['class' => 'validate', 'id' => 'email'])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('phoneNumber', 'Phone Number', ['for' => 'phoneNumber'])}}
                            {{Form::number('phoneNumber', $Customer->phoneNumber, ['class' => 'validate', 'id' => 'phoneNumber'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('EAN', 'EAN', ['for' => 'EAN'])}}
                            {{Form::number('EAN', $Customer->EAN, ['class' => 'validate', 'id' => 'EAN', 'data-length' => 14])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('CVR', 'CVR', ['for' => 'CVR'])}}
                            {{Form::number('CVR', $Customer->CVR, ['class' => 'validate', 'id' => 'CVR', 'data-length' => 8])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            {{Form::label('zipCode', 'Zip Code', ['for' => 'zipCode'])}}
                            {{Form::number('zipCode', $Customer->Address->zipCode, ['class' => 'validate', 'id' => 'zipCode'])}}
                        </div>
                        <div class="input-field col s12 m3">
                            {{Form::label('city', 'City', ['for' => 'city'])}}
                            {{Form::text('city', $Customer->Address->city, ['class' => 'validate', 'id' => 'city'])}}
                        </div>
                        <div class="input-field col s12 m3">
                            {{Form::label('street', 'Street', ['for' => 'street'])}}
                            {{Form::text('street', $Customer->Address->street, ['class' => 'validate', 'id' => 'street'])}}
                        </div>
                        <div class="input-field col s12 m3">
                                {{Form::label('streetNumber', 'Street Number', ['for' => 'streetNumber'])}}
                                {{Form::text('streetNumber', $Customer->Address->streetNumber, ['class' => 'validate', 'id' => 'streetNumber'])}}
                            </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6">
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::submit('Save edit to customer', ['class' => 'btn btn-large'])}}
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection
