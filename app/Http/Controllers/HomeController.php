<?php

namespace App\Http\Controllers;

use App\Services\Concrete\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $home_service;
    public function __construct(HomeService $home_service)
    {
        $this->middleware('auth');
        $this->home_service = $home_service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $state = $this->home_service->dasboard();
        return view('home',compact('state'));
    }
    public function cameras(){
        $cameras = $this->home_service->cameras();
        return response()->json($cameras);
    }
}
