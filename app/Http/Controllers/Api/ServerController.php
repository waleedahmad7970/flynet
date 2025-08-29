<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\ServerService;

class ServerController extends Controller
{
    protected $server_service;
    public function __construct(
        ServerService $server_service
    ) {
        $this->server_service = $server_service;
    }

    public function getServerDetails()
    {
        $server_details = $this->server_service->getServerDetails();

        return response()->json([
            'success' => true,
            'server' => $server_details
        ], 200);
    }
}
