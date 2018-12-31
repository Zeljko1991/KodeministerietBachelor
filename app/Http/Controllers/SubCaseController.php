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
        // $rules = [];
        // $this->validate($request, [
        //     'title' => 'required',
        //     'description' => 'required',
        //     'status' => 'required'
        // ]);
        // $i = 1;
        // $SubCase = new SubCase;
        // $SubCase->title = $request->input('title');
        // $SubCase->description = $request->input('description');
        // $SubCase->price = $request->input('price');
        // $SubCase->project_case_id = $request->input('project_case_id');
        // $SubCase->case_status_id = $request->input('status');
        // $SubCase->save();
        // foreach ($request->deliverable as $key => $value) {
        //     Deliverable::create([
        //         'title' => $value,
        //         'order' => $i,
        //         'sub_case_id' => $SubCase->id]);
        //         $i++;
        // }

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



        // return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase: '.$SubCase->title.' created');
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
    //     $this->validate($request, [
    //         'title' => 'required',
    //         'description' => 'required',
    //         'status' => 'required'
    //     ]);

    //     $i = 1;
    //     $SubCase = SubCase::find($id);
    //     $SubCase->title = $request->input('title');
    //     $SubCase->description = $request->input('description');
    //     $SubCase->price = $request->input('price');
    //     $SubCase->project_case_id = $request->input('project_case_id');
    //     $SubCase->case_status_id = $request->input('status');
    //     $SubCase->save();
    //     $titles = $request->deliverable;
    //     $ids = $request->delivID;
    //     foreach($titles as $key => $value) {
    //         if($value == null) {
    //             Deliverable::find($ids[$key])->delete();
    //         } else if (!array_key_exists($key, $ids)) {
    //             Deliverable::create([
    //                 'title' => $value,
    //                 'order' => $i,
    //                 'sub_case_id' => $SubCase->id
    //             ]);
    //             $i++;
    //         } else {
    //             $Deliverable = Deliverable::find($ids[$key]);
    //             $Deliverable->title = $value;
    //             $Deliverable->order = $i;
    //             $Deliverable->sub_case_id = $SubCase->id;
    //             $Deliverable->save();
    //             $i++;
    //         }
    //     }

    //     return redirect('/projectcase/'.$SubCase->project_case_id)->with('success', 'Subcase: '.$SubCase->title.' updated');
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
        // $ids = array();
        // foreach($decode['editedSubCase']['deliverables'] as $key => $value) {
        //     array_push($ids, 'id');
        // }

        // foreach($titles as $key => $value) {
        //     if($value['title'] == null) {
        //         Deliverable::find($ids[$value['id']])->delete();
        //     } else if (!array_key_exists($value['id'], $ids)) {
        //         Deliverable::create([
        //             'title' => $value['title'],
        //             'order' => $i,
        //             'sub_case_id' => $SubCase->id
        //         ]);
        //         $i++;
        //     } else {
        //         $Deliverable = Deliverable::find($ids[$value['id']]);
        //         $Deliverable->title = $value['title'];
        //         $Deliverable->order = $i;
        //         $Deliverable->sub_case_id = $SubCase->id;
        //         $Deliverable->save();
        //         $i++;
        //     }
        // }

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
