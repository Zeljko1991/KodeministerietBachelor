<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProjectCase = ProjectCase::whereHas('SubCases', function($query){$query->where('case_status_id', '!=', 5)->orderBy('deadline', 'desc');})->with('SubCases.Deliverables')->has('SubCases.Deliverables')->get();
        $AllCases = ProjectCase::all();
        return view('dashboard')->with(['ProjectCase' => $ProjectCase, 'AllCases' => $AllCases]);
    }
}
