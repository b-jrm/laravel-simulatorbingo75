<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function home(Request $request): View
    {
        // dd(file_get_contents(resource_path('views/designs/default/home.htm')));


        // dd(file_get_contents(view('modules.home.home', [
        //     'user' => $request->user(),
        // ])));

        return view('modules.home.home', [
            'user' => $request->user(),
        ]);
    }

    public function render(Request $request): View
    {
        return view('modules.home.home2', [
            'user' => $request->user(),
        ]);
    }

}
