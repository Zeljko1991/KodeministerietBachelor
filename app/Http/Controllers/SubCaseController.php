<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\SubCase;
use App\Models\Deliverable;
use App\Models\CaseStatus;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;

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
        $decode = $request->json()->all();
        $SubCase = new Subcase;
        $SubCase->title = $decode['editedSubCase']['title'];
        $SubCase->description = $decode['editedSubCase']['description'];
        $SubCase->price = $decode['editedSubCase']['price'];
        $SubCase->project_case_id = $decode['editedSubCase']['project_case_id'];
        $SubCase->save();
            $i=1;
            foreach ($decode['editedSubCase']['deliverables'] as $key => $value) {
                Deliverable::create([
                    'title' => $value['title'],
                    'order' => $i,
                    'sub_case_id' => $SubCase->id]);
                    $i++;
            }
        return response('Succezz', 200);
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

        $SubCase = SubCase::find($id);
        return response('Updated subcase', 200);
        // $CaseStatus = CaseStatus::pluck('stage', 'id');
        // $SubCase = SubCase::find($id);
        // $ProjectCase = $SubCase->ProjectCase;
        // return view('subcase.edit')->with([ 'SubCase'       => $SubCase,
        //                                     'ProjectCase'   => $ProjectCase,
        //                                     'CaseStatus'    => $CaseStatus]);
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
        $i = 1;
        $decode = $request->json()->all();
        $SubCase = SubCase::findOrFail($id);
        $SubCase->title = $decode['editedSubCase']['title'];
        $SubCase->description = $decode['editedSubCase']['description'];
        $SubCase->price = $decode['editedSubCase']['price'];
        $SubCase->project_case_id = $decode['editedSubCase']['project_case_id'];
        $SubCase->save();
        $titles = $decode['editedSubCase']['deliverables'];
        foreach ($SubCase->Deliverables as $Deliverable) {
            $Deliverable->delete();
        }
        foreach ($titles as $Deliverable) {
            Deliverable::create([
                'title' => $Deliverable['title'],
                'order' => $i,
                'price' => $Deliverable['price'],
                'sub_case_id' => $SubCase->id
            ]);
            $i++;
        }
        return response('Subcase updated', 200);
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
        // $SubCase->Deliverables()->delete();
        $SubCase->delete();
        // return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase removed');
        return response('Subcase deleted', 200);
    }

    /**
     * Store employee hrs on subcase.
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function hrs($id, Request $request)
     {
        $decode = $request->json()->all();
        $SubCase = SubCase::find($id);
        $User = Auth::user();
        $User->WorksOnSubCase()->attach($SubCase->id, ['user_id' => $User->id, 'hrs' => $decode['newHours']['hours']]);
        //return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Hours added');
        return response('Hours added.', 200);
     }
}
