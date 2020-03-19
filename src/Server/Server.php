<?php


namespace TitarLab\Server;


class Server
{
    public function getCron(){
        $cronList = $this->serverCrontabList();
        return response()->json(new Report("200",$cronList,"Задачи в crontab"));
    }

    public function getTotalSpace($direction){
        $bytes = disk_total_space($direction);
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    }
    public function getFreeSpace($direction){
        $bytes = disk_free_space($direction);
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    }
    public function getUsedSpace($direction){
        $bytes = $this->folderSize($direction);
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    }
    public function folderSize ($dir){
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }
    public function serverMemoryUsage() {
        $free = shell_exec('free -b');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2] / $mem[1] * 100;
        return $memory_usage;
    }
    public function serverMemoryFree() {
        $free = shell_exec('free -b');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_free =  $mem[3];
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($memory_free , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $memory_free / pow($base,$class)) . ' ' . $si_prefix[$class];
    }
    public function serverMemoryTotal() {
        $free = shell_exec('free -b');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_total =  $mem[1];
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($memory_total , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $memory_total / pow($base,$class)) . ' ' . $si_prefix[$class];
    }
    public function checkServiceStatus($service) {
        $status = shell_exec('systemctl is-active '.$service);
        $status = (string)trim($status);
        $status = (string)trim($status,"\n");
        return $status;
    }
    public function serverCrontabList() {
        $crontab = shell_exec('crontab -l ');
        if(strpos($crontab,"no crontab")){
            return "no crontab";
        }
        $crontab = (string)trim($crontab);
        $crontab = explode("\n", $crontab);

        $cronList = array();
        foreach ($crontab as $cronRow) {
            if(strlen($cronRow) > 0){
                $tempcron = explode(" ", $cronRow);
                error_log($cronRow);
                if(strpos($tempcron[0],"#") !== FALSE || strpos($tempcron[0],"MAILTO") !== FALSE){
                    continue;
                }
                $cron = array(
                    'm' => $tempcron[0],
                    'h' => $tempcron[1],
                    'dom' => $tempcron[2],
                    'mon' => $tempcron[3],
                    'dow' => $tempcron[4],
                    'command' => $tempcron[5],
                );
                for($i = 6; $i < count($tempcron); $i++){
                    $cron['command'] .= ' '.$tempcron[$i];
                }

                $cronList[] = $cron;
            }
        }
        return $cronList;
    }
    public function serverUptime() {
        // $uptime = floor(preg_replace ('/\.[0-9]+/', '', file_get_contents('/proc/uptime')) / 86400);
        // return $uptime;
    }
}