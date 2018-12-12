<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\SubCase;
use App\Models\CaseStatus;
use DB;

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
        $ProjectCases = ProjectCase::orderBy('created_at', 'desc')->paginate(5);
        return view('/projectcase.index')->with('ProjectCases', $ProjectCases);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CaseStatus = CaseStatus::pluck('stage', 'id');
        return view('/projectcase.create')->with('CaseStatus', $CaseStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        // Create Case
        $ProjectCase = new ProjectCase;
        $ProjectCase->title = $request->input('title');
        $ProjectCase->description = $request->input('description');
        $ProjectCase->case_status_id = $request->input('status');
        $ProjectCase->save();

        return redirect('/projectcase/'.$ProjectCase->id)->with('success', 'Case Created');
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
        $SubCases = SubCase::whereIn('project_case_id', $ProjectCase)->get();
        return view('projectcase.show')->with(['ProjectCase' => $ProjectCase, 'SubCases' => $SubCases]);
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        // Create Case
        $ProjectCase = ProjectCase::find($id);
        $ProjectCase->title = $request->input('title');
        $ProjectCase->description = $request->input('description');
        $ProjectCase->case_status_id = $request->input('status');
        $ProjectCase->save();

        return redirect('/projectcase/'.$ProjectCase->id)->with('success', 'Case: '.$ProjectCase->title.' Updated');
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
        return redirect('/projectcase')->with('success', 'Case Removed');
    }
}
