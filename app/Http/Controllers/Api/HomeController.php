<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\HomeService;

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

        return response()->json([
            'success' => true,
            'data' => $state
        ], 200);
    }
}
