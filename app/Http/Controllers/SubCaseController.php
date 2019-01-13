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
        //Validate the subcase info
        $this->validate($request, [
            'editedSubCase.title' => 'required',
            'editedSubCase.description' => 'required',
            'editedSubCase.price' => 'required',
            'editedSubCase.project_case_id' => 'required|numeric',
            'editedSubCase.deliverables.*.title' => 'required',
            'editedSubCase.deliverables.*.price' => 'nullable|numeric'
        ]);

        //Convert request to object
        $request = json_decode(json_encode($request->all()));
        
        //Create the new object
        $SubCase = new Subcase;
        $SubCase->title = $request->editedSubCase->title;
        $SubCase->description = $request->editedSubCase->description;
        $SubCase->price = $request->editedSubCase->price;
        $SubCase->project_case_id = $request->editedSubCase->project_case_id;
        $SubCase->save();
        //Loop through deliverables
            $i=1;
            foreach ($request->editedSubCase->deliverables as $key => $value) {
                Deliverable::create([
                    'title' => $value->title,
                    'order' => $i,
                    'sub_case_id' => $SubCase->id]);
                    $i++;
            }

        //Successful response    
        return response('Subcase created successfully!', 200);
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
        //Validate all update request inputs
        $this->validate($request, [
            'editedSubCase.title' => 'required',
            'editedSubCase.description' => 'required',
            'editedSubCase.price' => 'required',
            'editedSubCase.project_case_id' => 'required|numeric',
            'editedSubCase.deliverables.*.title' => 'required',
            'editedSubCase.deliverables.*.price' => 'nullable|numeric'

        ]);

        //Counter for deliverable order
        $i = 1;
        $decode = $request->json()->all();
        $request = json_decode(json_encode($request->all()));
        $SubCase = SubCase::findOrFail($id);
        $SubCase->title = $request->editedSubCase->title;
        $SubCase->description = $request->editedSubCase->description;
        $SubCase->price = $request->editedSubCase->price;
        $SubCase->project_case_id = $request->editedSubCase->project_case_id;
        $SubCase->save();
        
        $delivs_exist = Deliverable::where('sub_case_id', '=', $SubCase->id)->pluck('id');
        $newdelivs = array();

        //Loop through request deliverables and update or create
        foreach ($request->editedSubCase->deliverables as $deliverable) { 
            if(!isset($deliverable->id)) {
                Deliverable::create([
                    'title' => $deliverable->title,
                    'order' => $i,
                    'sub_case_id' => $SubCase->id
                ]); 
                $i++;
            } else if(isset($deliverable->id) || $delivs_exist->contains($deliverable->id)) {
                array_push($newdelivs, $deliverable->id);
                $Deliverable = Deliverable::find($deliverable->id);
                $Deliverable->title = $deliverable->title;
                $Deliverable->order = $deliverable->order;
                $Deliverable->stage = $deliverable->stage;
                $Deliverable->sub_case_id = $SubCase->id;
                $Deliverable->save();
                $i++;
            } 
        }
        //Check if deliverable exists in new request
        foreach($delivs_exist as $deliv) {
            if(!in_array($deliv, $newdelivs)){
                Deliverable::find($deliv)->delete();
            }
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
        //Find and delete subcase
        $SubCase = SubCase::find($id);
        $SubCase->delete();
        //Response for succesful delete
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
        $request = json_decode(json_encode($request->all()));
        
        $SubCase = SubCase::find($id);
        $User = Auth::user();
        $User->WorksOnSubCase()->attach($SubCase->id, ['user_id' => $User->id, 'hrs' => $request->newHours->hours]);

        //response for successful add of hours
        return response('Hours added.', 200);
     }
}
