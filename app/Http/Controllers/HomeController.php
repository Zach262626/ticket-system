<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home', [
            'tenants' => Tenant::all(),
            'domains' => Domain::get('domain')->toArray()
        ]);
    }

    /**
     * Show the test page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function test()
    {
        return view('test');
    }
}
