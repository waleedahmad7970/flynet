<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunObjectDetection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:objects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pythonPath = 'python'; // or full path like C:\\Python311\\python.exe
        $scriptPath = base_path('storage/app/multi_protocol_detector.py');

        $this->info('🎬 Starting object detection script...');

        $process = proc_open(
            "$pythonPath $scriptPath",
            [
                1 => ['pipe', 'w'], // STDOUT
                2 => ['pipe', 'w'], // STDERR
            ],
            $pipes
        );

        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            $error = stream_get_contents($pipes[2]);

            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            if ($output) {
                $this->info("✅ Output:\n$output");
            }
            if ($error) {
                $this->error("❌ Error:\n$error");
            }
        } else {
            $this->error('Failed to start Python process.');
        }
    }
}
