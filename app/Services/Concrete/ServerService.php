<?php

namespace App\Services\Concrete;
use Illuminate\Support\Facades\Cache;

class ServerService
{
    public function getServerDetails()
    {
        $os = strtolower(PHP_OS);

        if (str_contains($os, 'win')) {

            return $this->getWindowsStats();

        } else {

            return $this->getLinuxStats();

        }
    }

    private function getLinuxStats()
    {
        $serverName = gethostname();
        // Memory
        $meminfo = @file_get_contents('/proc/meminfo');

        preg_match_all('/(\w+):\s+(\d+)\s+kB/', $meminfo, $matches, PREG_SET_ORDER);
        $memData = [];
        foreach ($matches as $match) {
            $memData[$match[1]] = (float)$match[2];
        }

        $requiredKeys = ['MemTotal', 'MemAvailable'];
        if (count(array_intersect($requiredKeys, array_keys($memData))) < count($requiredKeys)) {
           // Log::error("Missing keys in /proc/meminfo");
            return null;
        }

        $totalKB = $memData['MemTotal'];
        $freeKB = $memData['MemAvailable'];
        $usedKB = $totalKB - $freeKB;

        $memory = $this->calculateMemoryValues($totalKB, $usedKB);

        // storage
        $storage = $this->getDiskUsage('/');

        // Network stats
        $netRaw = shell_exec("cat /proc/net/dev | grep -E 'eth0|ens|enp'"); // may vary by VPS
        preg_match_all('/\s*(\w+):\s*(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+(\d+)/', $netRaw, $matches);
        $network = [];
        foreach ($matches[1] as $i => $iface) {
            $network[$iface] = [
                'received_MB' => round($matches[2][$i] / 1024 / 1024, 2),
                'sent_MB'     => round($matches[3][$i] / 1024 / 1024, 2)
            ];
        }

        $cpu = $this->getCpuInfo();

        return [
            'server_name' => $serverName,
            'os'         => php_uname(),
            'memory'     => $memory,
            'storage'    => $storage,
            'network_MB' => $network,
        //    'cpu_Usage' => $this->getLinuxCpuUsage() . '%',
            'cpu' => $cpu,
            'php_version'=> PHP_VERSION
        ];
    }

    private function getWindowsStats()
    {
        $serverName = gethostname();
        // Memory
        $output = shell_exec('wmic OS get TotalVisibleMemorySize,FreePhysicalMemory /Value 2>&1');

        preg_match('/TotalVisibleMemorySize=(\d+)/', $output, $totalMatches);
        preg_match('/FreePhysicalMemory=(\d+)/', $output, $freeMatches);

        $totalKB = (float)$totalMatches[1];
        $freeKB = (float)$freeMatches[1];
        $usedKB = $totalKB - $freeKB;

        $memory = $this->calculateMemoryValues($totalKB, $usedKB);

        $storage = $this->getDiskUsage('C:');

        // Network stats (basic)
        $netRaw = shell_exec('netstat -e');
        preg_match('/Bytes\s+(\d+)\s+(\d+)/', $netRaw, $matches);
        $network = [
            'received_MB' => isset($matches[1]) ? round($matches[1] / 1024 / 1024, 2) : 0,
            'sent_MB'     => isset($matches[2]) ? round($matches[2] / 1024 / 1024, 2) : 0
        ];

        $cpu = $this->getCpuInfo();

        return [
            'server_name' => $serverName,
            'os'         => php_uname(),
            'memory'     => $memory,
            'storage'    => $storage,
            'network_MB' => $network,
        //    'cpu_Usage' => $this->getWindowsCpuUsage() . '%',
            'cpu' => $cpu,
            'php_version'=> PHP_VERSION
        ];
    }

    /**
     * Linux CPU Usage
     */
    private function getLinuxCpuUsage()
    {
        $stat1 = file('/proc/stat');
        sleep(1);
        $stat2 = file('/proc/stat');

        $info1 = $this->getCpuTimes($stat1[0]);
        $info2 = $this->getCpuTimes($stat2[0]);

        $totalTime1 = array_sum($info1);
        $totalTime2 = array_sum($info2);

        $idleTime1 = $info1['idle'];
        $idleTime2 = $info2['idle'];

        $totalDiff = $totalTime2 - $totalTime1;
        $idleDiff  = $idleTime2 - $idleTime1;

        $cpuUsage = (1 - ($idleDiff / $totalDiff)) * 100;

        return round($cpuUsage, 2);
    }

    /**
     * Windows CPU Usage
     */
    private function getWindowsCpuUsage()
    {
        // This works on Windows via WMIC command
        $output = shell_exec('wmic cpu get loadpercentage /value');
        preg_match('/LoadPercentage=(\d+)/', $output, $matches);

        return isset($matches[1]) ? (float)$matches[1] : 0.0;
    }

    private function getCpuTimes($statLine)
    {
        $parts = preg_split('/\s+/', trim($statLine));
        return [
            'user' => (int)$parts[1],
            'nice' => (int)$parts[2],
            'system' => (int)$parts[3],
            'idle' => (int)$parts[4],
            'iowait' => (int)$parts[5],
            'irq' => (int)$parts[6],
            'softirq' => (int)$parts[7],
        ];
    }

    function calculateMemoryValues($totalKB, $usedKB)
    {
        $gbFactor = 1024 * 1024; // Convert KB to GB (1 GB = 1024 * 1024 KB)

        $usedGB = $usedKB / $gbFactor;
        $totalGB = $totalKB / $gbFactor;
        $usedPercentage = ($usedKB / $totalKB) * 100;

        return [
            'used_gb' => round($usedGB, 2),
            'total_gb' => round($totalGB, 2),
            'used_percentage' => round($usedPercentage, 2),
        ];
    }

    function getDiskUsage($path = null)
    {
        if ($path === null) {
            $path = base_path(); // Application root directory
        }

        $totalBytes = disk_total_space($path);
        $freeBytes = disk_free_space($path);

        if ($totalBytes === false || $freeBytes === false) {
          //  Log::error("Failed to read disk space for path: $path");
            return null;
        }

        $usedBytes = $totalBytes - $freeBytes;
        $gbFactor = 1024 * 1024 * 1024; // 1 GB in bytes

        $usedGB = $usedBytes / $gbFactor;
        $totalGB = $totalBytes / $gbFactor;
        $usedPercentage = ($usedBytes / $totalBytes) * 100;

        return [
            'used_gb' => round($usedGB, 2),
            'total_gb' => round($totalGB, 2),
            'used_percentage' => round($usedPercentage, 2),
        ];
    }

    function getCpuInfo()
    {
        $os = strtoupper(PHP_OS_FAMILY);

        if ($os === 'LINUX') {
            $cpuInfo = @file_get_contents('/proc/cpuinfo');
            preg_match_all('/model name\s*:\s*(.+)/', $cpuInfo, $matches);
            $model = $matches[1][0] ?? 'Unknown';

            return [
                'model' => trim($model),
                'cores' => (int)shell_exec('nproc'),
                'usage_percent' => $this->getCpuUsage()
            ];
        }

        if ($os === 'WINDOWS') {
            $output = shell_exec('wmic cpu get name,numberofcores');
            preg_match('/\n(.+?)\s+(\d+)/', $output, $matches);

            return [
                'model' => $matches[1] ?? 'Unknown',
                'cores' => (int)($matches[2] ?? shell_exec('echo %NUMBER_OF_PROCESSORS%')),
                'usage_percent' => $this->getCpuUsage()
            ];
        }

        return ['model' => 'Unknown', 'cores' => 0];
    }

    function getCpuUsage()
    {
        return Cache::remember('cpu_usage', 1, function() {
            if (strtoupper(PHP_OS_FAMILY) === 'LINUX') {
                $stat1 = file('/proc/stat');
                sleep(1);
                $stat2 = file('/proc/stat');

                $info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));
                $info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0]));

                $dif = [];
                $dif['user'] = $info2[0] - $info1[0];
                $dif['nice'] = $info2[1] - $info1[1];
                $dif['sys'] = $info2[2] - $info1[2];
                $dif['idle'] = $info2[3] - $info1[3];
                $total = array_sum($dif);

                return round(($total - $dif['idle']) / $total * 100, 2);
            }

            if (strtoupper(PHP_OS_FAMILY) === 'WINDOWS') {
                $output = shell_exec('wmic cpu get loadpercentage');
                preg_match('/(\d+)/', $output, $matches);
                return (int)($matches[0] ?? 0);
            }

            return 0;
        });
    }
}
