<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScanMediaMtxRecordings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan:media-recordings';

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
    $baseFolder = storage_path("app/recordings");

    if (!is_dir($baseFolder)) {
        $this->error("Base recordings folder not found: $baseFolder");
        return;
    }

    $cameraFolders = \File::directories($baseFolder);

    foreach ($cameraFolders as $folderPath) {
        $cameraSlug = basename($folderPath); // e.g., cam_1

        $camera = \App\Models\Camera::where('slug', $cameraSlug)->first();

        if (!$camera) {
            $this->warn("Camera not found for slug: $cameraSlug");
            continue;
        }

        $files = \File::files($folderPath);

        foreach ($files as $file) {
            $filename = $file->getFilename();
        
            // match filenames like: 2025-08-01_07-08-53-330114.mp4
            if (preg_match('/(\d{4}-\d{2}-\d{2})_(\d{2})-(\d{2})-(\d{2})-(\d+)\.mp4$/', $filename, $matches)) {
                $datetime = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H-i-s.u',
                    "{$matches[1]} {$matches[2]}-{$matches[3]}-{$matches[4]}.{$matches[5]}"
                );
        
                $startTime = $datetime;
                $endTime = $startTime->copy()->addSeconds(60);
        
                
                    // Destination directory: public/recordings/{camera_id}
                    $destinationDir = public_path("recordings/cam_{$camera->id}");
                    if (!is_dir($destinationDir)) {
                        mkdir($destinationDir, 0755, true);
                    }

                    // Move file from storage to public folder
                    $newPath = "{$destinationDir}/{$filename}";
                    try {
                        \File::copy($file->getRealPath(), $newPath);
                    // \File::move($file->getRealPath(), $newPath);
                    } catch (\Exception $e) {
                        $this->warn("Failed to move $filename: " . $e->getMessage());
                        continue;
                    }
                    

                \App\Models\CameraRecording::firstOrCreate([
                    'camera_id'      => $camera->id,
                    'file_path'      => "recordings/{$cameraSlug}/{$filename}",
                    'start_time'     => $startTime,
                    'end_time'       => $endTime,
                    'recording_type' => 'segment',
                ]);
            }
        }
        

        $this->info("Scanned: $cameraSlug | Total files: " . count($files)." | folderPath: ".$newPath);
    }

    $this->info("All camera folders scanned.");
}

    
}
