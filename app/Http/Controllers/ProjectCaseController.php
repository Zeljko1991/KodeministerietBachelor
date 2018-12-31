<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\SubCase;
use App\Models\Deliverable;
use App\Models\CaseStatus;
use DB;
use App\Models\Customer;

class ProjectCaseController extends Controller
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
        $ProjectCases = ProjectCase::orderBy('created_at', 'desc')->with('CaseStatus')->with('SubCases')->get();
        $Case_Statuses = CaseStatus::all();
        $Customers = Customer::all();
        return view('/projectcase.index')->with(['ProjectCases' => $ProjectCases, 'Customers' => $Customers, 'CaseStatus' => $Case_Statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CaseStatus = CaseStatus::pluck('stage', 'id');
        $Customers = Customer::get()->pluck('full_name', 'id');
        return view('/projectcase.create')->with(['CaseStatus' => $CaseStatus, 'Customers' => $Customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $decode = $request->json()->all();
        $ProjectCase = new ProjectCase;
        $ProjectCase->description = $decode['editedProjectCase']['description'];
        $ProjectCase->title = $decode['editedProjectCase']['title'];
        $ProjectCase->customer_id = $decode['editedProjectCase']['customer_id'];
        $ProjectCase->save();

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
        $ProjectCase = ProjectCase::find($id);
        $SubCases = SubCase::where('project_case_id', $id)->with('Deliverables')->with('UserWorksOn')->get();
        $CaseStatuses = CaseStatus::all();

        return view('projectcase.show')->with(['ProjectCase' => $ProjectCase, 'SubCases' => $SubCases, 'CaseStatus' => $CaseStatuses]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $CaseStatus = CaseStatus::pluck('stage', 'id');
        $ProjectCase = ProjectCase::find($id);
        return view('projectcase.edit')->with(['ProjectCase' => $ProjectCase, 'CaseStatus' => $CaseStatus]);
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
        // Create Case
        $ProjectCase = ProjectCase::findOrFail($id);
        $ProjectCase->title = $decode['editedProjectCase']['title'];
        $ProjectCase->description = $decode['editedProjectCase']['description'];
        $ProjectCase->case_status_id = $decode['editedProjectCase']['case_status_id'];
        $ProjectCase->save();

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
        $ProjectCase = ProjectCase::find($id);
        $ProjectCase->SubCases()->delete();
        $ProjectCase->delete();
        return response('Deleted Project.', 200);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        // Getting Customer from the Customer Model and ordering entries by id and ascending
        $ProjectCases = ProjectCase::orderBy('created_at', 'desc')->with('CaseStatus')->with('SubCases')->with('SubCases.UserWorksOn')->get();
        $Customers = Customer::all();
        return array($ProjectCases);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showread($id)
    {
        $ProjectCase = ProjectCase::find($id);
        $SubCases = SubCase::where('project_case_id', $id)->with('Deliverables')->with('UserWorksOn')->get();

        return array('ProjectCase' => $ProjectCase, 'SubCases' => $SubCases);
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatestatus(Request $request, $id)
    {
        $decode = $request->json()->all();
        // Create Case
        $ProjectCase = ProjectCase::findOrFail($id);
        $ProjectCase->case_status_id = $decode['editedProjectCase'];
        $ProjectCase->save();

        return response('Update Successful.', 200);
    }
}
