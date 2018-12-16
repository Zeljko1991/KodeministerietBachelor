@extends('layouts.app')

@section('content')
    <h1>Create Customer</h1>
    <div class="row">
        <div class="card">
            <div class="row">
                {!!Form::open(['action' => 'CustomerController@store', 'method' => 'POST', 'class' => 'col s12'])!!}
                <div class="card-content">
                    <span class="card-title">New</span>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('firstName', 'First Name', ['for' => 'firstName'])}}
                            {{Form::text('firstName', '', ['class' => 'validate', 'id' => 'firstName'])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('lastName', 'Last Name', ['for' => 'lastName'])}}
                            {{Form::text('lastName', '', ['class' => 'validate', 'id' => 'lastName'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('eMail','Email', ['for' => 'email'])}}
                            {{Form::text('eMail', '', ['class' => 'validate', 'id' => 'email'])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('phoneNumber', 'Phonenumber', ['for' => 'phoneNumber'])}}
                            {{Form::number('phoneNumber', '', ['class' => 'validate', 'id' => 'phoneNumber'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            {{Form::label('EAN', 'EAN', ['for' => 'EAN'])}}
                            {{Form::number('EAN', '', ['class' => 'validate', 'id' => 'EAN', 'data-length' => 14])}}
                        </div>
                        <div class="input-field col s12 m6">
                            {{Form::label('CVR', 'CVR', ['for' => 'CVR'])}}
                            {{Form::number('CVR', '', ['class' => 'validate', 'id' => 'CVR', 'data-length' => 8])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            {{Form::label('zipCode', 'Zip Code', ['for' => 'zipCode'])}}
                            {{Form::number('zipCode', '', ['class' => 'validate', 'id' => 'zipCode'])}}
                        </div>
                        <div class="input-field col s12 m3">
                            {{Form::label('city', 'City', ['for' => 'city'])}}
                            {{Form::text('city', '', ['class' => 'validate', 'id' => 'city'])}}
                        </div>
                        <div class="input-field col s12 m3">
                            {{Form::label('street', 'Street', ['for' => 'street'])}}
                            {{Form::text('street', '', ['class' => 'validate', 'id' => 'street'])}}
                        </div>
                        <div class="input-field col s12 m3">
                                {{Form::label('streetNumber', 'Street Number', ['for' => 'streetNumber'])}}
                                {{Form::text('streetNumber', '', ['class' => 'validate', 'id' => 'streetNumber'])}}
                            </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            {{Form::label('country', 'Country', ['for' => 'country'])}}
                            {{Form::text('country', '', ['class' => 'validate', 'id' => 'country'])}}
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6">
                            {{Form::submit('Create customer', ['class' => 'btn btn-large'])}}
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection
