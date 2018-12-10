<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use DB;

class ProjectCaseController extends Controller
{
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
        return view('/projectcase.create');
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
            'description' => 'required'
        ]);

        // Create Case
        $ProjectCase = new ProjectCase;
        $ProjectCase->title = $request->input('title');
        $ProjectCase->description = $request->input('description');
        $ProjectCase->save();

        return redirect('/projectcase')->with('success', 'Case Created');
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
        return view('projectcase.show')->with('ProjectCase', $ProjectCase);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ProjectCase = ProjectCase::find($id);
        return view('projectcase.edit')->with('ProjectCase', $ProjectCase);
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
            'description' => 'required'
        ]);

        // Create Case
        $ProjectCase = new ProjectCase;
        $ProjectCase->title = $request->input('title');
        $ProjectCase->description = $request->input('description');
        $ProjectCase->save();

        return redirect('/projectcase')->with('success', 'Case Updated');
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
        $ProjectCase->delete();
        return redirect('/projectcase')->with('success', 'Post Removed');
    }
}
