<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = 'Welcome to Kodeministeriet';
        return view('pages.index')->with('title', $title);
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
