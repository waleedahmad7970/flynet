<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Camera;
use App\Models\Group;
use App\Mail\PanicAlertEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckStreamStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stream:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check RTSP/RTMP stream status via MediaMTX and alert users if offline';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $response = Http::get('http://127.0.0.1:8888/v3/paths/list'); // Change IP if needed

            if (!$response->ok()) {
                $this->error('Failed to connect to MediaMTX API.');
                return;
            }

            $activeStreams = collect($response->json()['items'] ?? [])->pluck('name')->toArray();

            $cameras = Camera::with('alarms.users')->get();

            foreach ($cameras as $camera) {
                $isOnline = in_array($camera->stream_key, $activeStreams);

                if (!$isOnline) {
                    foreach ($camera->alarms as $alarm) {
                        foreach ($alarm->users as $user) {
                            Mail::to($user->email)->send(new PanicAlertEmail($camera, $alarm, $user));
                        }

                        $this->info("Alert sent for offline camera: {$camera->name} in alarm: {$alarm->name}");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in stream:check-status: ' . $e->getMessage());
        }
    }
}
