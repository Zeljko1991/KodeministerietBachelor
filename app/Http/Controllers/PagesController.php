<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
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

    public function index() {
            return view('/dashboard');
    }

    public function billing() {
        $title = 'Billing';
        return view('billing.billing')->with('title', $title);
    }

    public function marketing() {
        $title = 'Marketing';
        return view('marketing.marketing')->with('title', $title);
    }

}
