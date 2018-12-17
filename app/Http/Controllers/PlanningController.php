<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deliverable;
use App\Models\SubCase;

class PlanningController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SubCase = SubCase::find($id);
        $Deliverables = Deliverable::where('sub_case_id', $id)->orderBy('order', 'asc')->get();

        $DeliverablesTodo = $Deliverables->filter(function($Deliverables, $key) {
            return $Deliverables->stage == 1;
        })->values();

        $DeliverablesDoing = $Deliverables->filter(function($Deliverables, $key) {
            return $Deliverables->stage == 2;
        })->values();

        $DeliverablesDone = $Deliverables->filter(function($Deliverables, $key) {
            return $Deliverables->stage == 3;
        })->values();

        return view('planning.show')->with([    'SubCase' => $SubCase,
                                                'Deliverables' => $Deliverables,
                                                'DeliverablesTodo' => $DeliverablesTodo,
                                                'DeliverablesDoing' => $DeliverablesDoing,
                                                'DeliverablesDone' => $DeliverablesDone
                                    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $DeliverablesBE = Deliverable::where('sub_case_id', $id)->get();
        foreach($DeliverablesBE as $itemBE) {
            $id = $itemBE->id;
            foreach($request->deliverables as $itemFE) {
                if($itemFE['id'] == $id) {
                    $itemBE->update(['order' => $itemFE['order']]);
                }
            }
        }

        return response('Update Successful.', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deliverable $Deliverable
     * @return \Illuminate\Http\Response
     */
     public function visibility(Request $request, Deliverable $Deliverables)
     {
         $Deliverables->stage = $request->stage;
         $Deliverables->save();
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
        //
    }
}
