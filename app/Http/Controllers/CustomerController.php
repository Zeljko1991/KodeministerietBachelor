<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Address;
use DB;

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
        $Customers = Customer::orderBy('id', 'asc')->paginate(10);
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
        // Validating that input fields are filled
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'eMail' => 'required',
            'phoneNumber' => 'required',
            'EAN' => 'required_without:CVR',
            'CVR' => 'required_without:EAN',
            'zipCode' => 'required',
            'city' => 'required',
            'street' => 'required',
            'streetNumber' => 'required',
            'country' => 'required',
            ]);

        // Create Customer
        $Address = new Address;
        $Address->streetNumber = $request->input('streetNumber');
        $Address->city = $request->input('city');
        $Address->street = $request->input('street');
        $Address->zipCode = $request->input('zipCode');
        $Address->country = $request->input('country');
        $Address->save();
        $Customer = new Customer;
        $Customer->address_id = $Address->id;
        $Customer->firstName = $request->input('firstName');
        $Customer->lastName = $request->input('lastName');
        $Customer->eMail = $request->input('eMail');
        $Customer->phoneNumber = $request->input('phoneNumber');
        $Customer->EAN = $request->input('EAN');
        $Customer->CVR = $request->input('CVR');
        $Customer->save();

        return redirect('/customer')->with('success', 'Customer Created');
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
           // Validating that input fields are filled
           $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'eMail' => 'required',
            'phoneNumber' => 'required',
            'EAN' => 'required_without:CVR',
            'CVR' => 'required_without:EAN',
            'zipCode' => 'required',
            'city' => 'required',
            'street' => 'required',
            'streetNumber' => 'required',
            'country' => 'required',
            ]);

        // Create Customer
        $Customer = Customer::find($id);
        $Customer->firstName = $request->input('firstName');
        $Customer->lastName = $request->input('lastName');
        $Customer->eMail = $request->input('eMail');
        $Customer->phoneNumber = $request->input('phoneNumber');
        $Customer->EAN = $request->input('EAN');
        $Customer->CVR = $request->input('CVR');
        $Customer->save();
        $Address = Address::find($Customer->address_id);
        $Address->streetNumber = $request->input('streetNumber');
        $Address->city = $request->input('city');
        $Address->street = $request->input('street');
        $Address->zipCode = $request->input('zipCode');
        $Address->country = $request->input('country');
        $Address->save();

        // Returns view to customer.show (old view)
        // return redirect('/customer/'.$Customer->id)->with('success', 'Customer Updated');

        return redirect('/customer')->with('success', 'Customer Updated');
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
        return redirect('/customer')->with('success', 'Customer Deleted');
    }
}
