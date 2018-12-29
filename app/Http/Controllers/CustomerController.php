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
        // Validating that input fields are filled
        // $this->validate($request, [
        //     'companyName' => 'required',
        //     'firstName' => 'required',
        //     'lastName' => 'required',
        //     'eMail' => 'required',
        //     'phoneNumber' => 'required',
        //     'EAN' => 'required_without:CVR',
        //     'CVR' => 'required_without:EAN',
        //     'zipCode' => 'required',
        //     'city' => 'required',
        //     'street' => 'required',
        //     'streetNumber' => 'required',
        //     'country' => 'required',
        //     ]);
        $decode = $request->json()->all();
        $Address = new Address;
        $Address->streetNumber = $decode['editedCustomer']['address']['streetNumber'];
        $Address->city = $decode['editedCustomer']['address']['city'];
        $Address->street = $decode['editedCustomer']['address']['street'];
        $Address->zipCode = $decode['editedCustomer']['address']['zipCode'];
        $Address->country = $decode['editedCustomer']['address']['country'];
        $Address->save();
        $Customer = new Customer;
        $Customer->companyName = $decode['editedCustomer']['companyName'];
        $Customer->firstName = $decode['editedCustomer']['firstName'];
        $Customer->lastName = $decode['editedCustomer']['lastName'];
        $Customer->eMail = $decode['editedCustomer']['eMail'];
        $Customer->phoneNumber = $decode['editedCustomer']['phoneNumber'];
        $Customer->EAN = $decode['editedCustomer']['EAN'];
        $Customer->CVR = $decode['editedCustomer']['CVR'];
        $Customer->address_id = $Address->id;
        $Customer->save();
        

        return response('Success!', 200);
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
        $decode = $request->json()->all();
        $Customer = Customer::findOrFail($id);
        $Customer->companyName = $decode['editedCustomer']['companyName'];
        $Customer->firstName = $decode['editedCustomer']['firstName'];
        $Customer->lastName = $decode['editedCustomer']['lastName'];
        $Customer->eMail = $decode['editedCustomer']['eMail'];
        $Customer->phoneNumber = $decode['editedCustomer']['phoneNumber'];
        $Customer->EAN = $decode['editedCustomer']['EAN'];
        $Customer->CVR = $decode['editedCustomer']['CVR'];
        $Customer->save();
        $Address = Address::find($Customer->address_id);
        $Address->streetNumber = $decode['editedCustomer']['address']['streetNumber'];
        $Address->city = $decode['editedCustomer']['address']['city'];
        $Address->street = $decode['editedCustomer']['address']['street'];
        $Address->zipCode = $decode['editedCustomer']['address']['zipCode'];
        $Address->country = $decode['editedCustomer']['address']['country'];
        $Address->save();


        return response('Update Successful.', 200);
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
        $Customers = Customer::orderBy('id', 'asc')->with('Address')->get();
        return array($Customers);
    }
}
