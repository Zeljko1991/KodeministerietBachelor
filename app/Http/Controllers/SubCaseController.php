<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\SubCase;
use App\Models\Deliverable;
use App\Models\CaseStatus;
use SebastianBergmann\Environment\Console;

class SubCaseController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $CaseStatus = CaseStatus::pluck('stage', 'id');
        $ProjectCase = ProjectCase::find($id);
        return view('subcase.create', ['ProjectCase' => $ProjectCase, 'CaseStatus' => $CaseStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);
        $i = 1;
        $SubCase = new SubCase;
        $SubCase->title = $request->input('title');
        $SubCase->description = $request->input('description');
        $SubCase->price = $request->input('price');
        $SubCase->project_case_id = $request->input('project_case_id');
        $SubCase->case_status_id = $request->input('status');
        $SubCase->save();
        foreach ($request->deliverable as $key => $value) {
            Deliverable::create([
                'title' => $value,
                'order' => $i,
                'sub_case_id' => $SubCase->id]);
                $i++;
        }



        return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase: '.$SubCase->title.' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $SubCase = SubCase::find($id);
        $ProjectCase = $SubCase->ProjectCase;
        return view('subcase.edit')->with([ 'SubCase'       => $SubCase,
                                            'ProjectCase'   => $ProjectCase,
                                            'CaseStatus'    => $CaseStatus]);
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

        $i = 1;
        $SubCase = SubCase::find($id);
        $SubCase->title = $request->input('title');
        $SubCase->description = $request->input('description');
        $SubCase->price = $request->input('price');
        $SubCase->project_case_id = $request->input('project_case_id');
        $SubCase->case_status_id = $request->input('status');
        $SubCase->save();
        $titles = $request->deliverable;
        $ids = $request->delivID;
        foreach($titles as $key => $value) {
            if($value == null) {
                Deliverable::find($ids[$key])->delete();
            } else if (!array_key_exists($key, $ids)) {
                Deliverable::create([
                    'title' => $value,
                    'order' => $i,
                    'sub_case_id' => $SubCase->id
                ]);
                $i++;
            } else {
                $Deliverable = Deliverable::find($ids[$key]);
                $Deliverable->title = $value;
                $Deliverable->order = $i;
                $Deliverable->sub_case_id = $SubCase->id;
                $Deliverable->save();
                $i++;
            }
        }

        return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase: '.$SubCase->title.' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SubCase = SubCase::find($id);
        $SubCase->Deliverables()->delete();
        $SubCase->delete();
        return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase removed');
    }
}
