<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth()->user()->perfil == Config::get('constants.PERFIL_USUARIO.CANTINEIRO', 1)) {
            return redirect('/canteen');
        }

        if(Auth()->user()->perfil == Config::get('constants.PERFIL_USUARIO.RESPONSAVEL', 2)) {
            return redirect('/dad');
        }

        return view('home');
    }
}
