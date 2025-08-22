<?php

namespace App\Http\Controllers;

use App\Services\Concrete\ServerService;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    protected $server_service;
    public function __construct(
        ServerService $server_service
    ) {
        $this->server_service = $server_service;
    }

    public function index()
    {
        $server_details = $this->server_service->getServerDetails();

        return view('server.index', compact('server_details'));
    }
}
