<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Address;
use DB;
use function GuzzleHttp\json_decode;

class CustomerController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Getting Customer from the Customer Model and ordering entries by id and ascending
        $Customers = Customer::orderBy('id', 'asc')->with('Address')->with('ProjectCase')->get();
        return view('/customer.index')->with('Customers', $Customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validating the sent data
        $this->validate($request, [
            //Validating address first
            'editedCustomer.address.streetNumber' => 'required',
            'editedCustomer.address.city' => 'required',
            'editedCustomer.address.street' => 'required',
            'editedCustomer.address.zipCode' => 'required',
            'editedCustomer.address.country' => 'required',

            //Then validating customerinfo
            'editedCustomer.companyName' => 'required',
            'editedCustomer.firstName' => 'required',
            'editedCustomer.lastName' => 'required',
            'editedCustomer.eMail' => 'required|email',
            'editedCustomer.phoneNumber' => 'required|numeric',
            'editedCustomer.CVR' => 'required_without:editedCustomer.EAN',
            'editedCustomer.EAN' => 'required_without:editedCustomer.CVR',
            
        ]);

        //Converting JSON to object so as to maintain Laravel syntax
        $request = json_decode(json_encode($request->all()));

        //Creating the address
        $Address = new Address;
        $Address->streetNumber = $request->editedCustomer->address->streetNumber;
        $Address->city = $request->editedCustomer->address->city;
        $Address->street = $request->editedCustomer->address->street;
        $Address->zipCode = $request->editedCustomer->address->zipCode;
        $Address->country = $request->editedCustomer->address->country;
        $Address->save();

        //Creating the customer after address is saved
        $Customer = new Customer;
        $Customer->companyName = $request->editedCustomer->companyName;
        $Customer->firstName = $request->editedCustomer->firstName;
        $Customer->lastName = $request->editedCustomer->lastName;
        $Customer->eMail = $request->editedCustomer->eMail;
        $Customer->phoneNumber = $request->editedCustomer->phoneNumber;
        $Customer->EAN = $request->editedCustomer->EAN;
        $Customer->CVR = $request->editedCustomer->CVR;
        $Customer->address_id = $Address->id;
        $Customer->save();
        
        //Returning response with success message
        return response('Customer created!', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Customer = Customer::find($id);
        return view('customer.show')->with('Customer', $Customer);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Customer = Customer::find($id);
        return view('customer.edit')->with('Customer', $Customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validating the update data
        $this->validate($request, [
            //Validating address first
            'editedCustomer.address.streetNumber' => 'required',
            'editedCustomer.address.city' => 'required',
            'editedCustomer.address.street' => 'required',
            'editedCustomer.address.zipCode' => 'required',
            'editedCustomer.address.country' => 'required',

            //Then validating customerinfo
            'editedCustomer.companyName' => 'required',
            'editedCustomer.firstName' => 'required',
            'editedCustomer.lastName' => 'required',
            'editedCustomer.eMail' => 'required|email',
            'editedCustomer.phoneNumber' => 'required|numeric',
            'editedCustomer.CVR' => 'required_without:editedCustomer.EAN',
            'editedCustomer.EAN' => 'required_without:editedCustomer.CVR',
            
        ]);

        //Convert data to object
        $request = json_decode(json_encode($request->all()));

        //Find customer if exists, then update said customer
        $Customer = Customer::findOrFail($id);
        $Customer->companyName = $request->editedCustomer->companyName;
        $Customer->firstName = $request->editedCustomer->firstName;
        $Customer->lastName = $request->editedCustomer->lastName;
        $Customer->eMail = $request->editedCustomer->eMail;
        $Customer->phoneNumber = $request->editedCustomer->phoneNumber;
        $Customer->EAN = $request->editedCustomer->EAN;
        $Customer->CVR = $request->editedCustomer->CVR;
        $Customer->save();

        //Find customers address, then update
        $Address = Address::find($Customer->address_id);
        $Address->streetNumber = $request->editedCustomer->address->streetNumber;
        $Address->city = $request->editedCustomer->address->city;
        $Address->street = $request->editedCustomer->address->street;
        $Address->zipCode = $request->editedCustomer->address->zipCode;
        $Address->country = $request->editedCustomer->address->country;
        $Address->save();

        //Custom response message
        return response('Customer updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Customer = Customer::find($id);
        $Customer->delete();
        return response('Deleted customer.', 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        // Getting Customer from the Customer Model and ordering entries by id and ascending
        $Customers = Customer::orderBy('id', 'asc')->with('Address')->with('ProjectCase')->get();
        return array($Customers);
    }
}
