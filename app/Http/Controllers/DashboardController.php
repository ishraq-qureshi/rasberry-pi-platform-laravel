<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RasberryPiNotification;

class DashboardController extends Controller
{
    public function view () {
        
        $user = Auth::user();

        $data = [];

        if($user->hasRole('superadmin')){
            return view('livewire.pages.manage-dashboard.superadmin');
        }

        if($user->hasRole('admin')){
            $rasberryPis = $user->raspberryPis;
            $data["totalDevices"] = array(
                "online" => 0,
                "offline" => 0,
            );
            $data["cpuUsage"] = array();

            $data["ramUsage"] = array();

            $data["storageUsage"] = array(
                "names" => array(),
                "series" => array(
                    array(
                        "name" => "Free Space",
                        "color" => "#31C48D",
                        "data" => array()
                    ),
                    array(
                        "name" => "Used",
                        "color" => "#F05252",
                        "data" => array()
                    ),
                ),
            );

            foreach($rasberryPis as $key => $pi) {
                if($pi->isOnline()) {
                    $data["totalDevices"]["online"] = $data["totalDevices"]["online"] + 1;
                } else {
                    $data["totalDevices"]["offline"] = $data["totalDevices"]["offline"] + 1;
                }

                
                if(isset($pi->analytics)) {
                    
                    array_push($data["storageUsage"]["names"], $pi->pi_name);
                    $storageDataUsed = floatval($pi->analytics->storage_usage);
                    $storageDataFree = 100 - floatval($pi->analytics->storage_usage);
                    array_push($data["storageUsage"]["series"][0]["data"], number_format((float)$storageDataFree, 2, '.', ''));
                    array_push($data["storageUsage"]["series"][1]["data"], number_format((float)$storageDataUsed, 2, '.', ''));
                }                

                $maxCpuData = 0;
                $maxRamData = 0;
                
                $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                ->where('created_at', '>=', Carbon::now()->subDay())
                ->orderBy('created_at', 'desc')
                ->get();;

                if(isset($notifications) && count($notifications) > 0) {
                    $_TMP_CPU_DATA = [];
                    $_TMP_CPU_DATA["name"] = $pi->pi_name;
                    $_TMP_CPU_DATA["color"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    $_TMP_CPU_DATA["data"] = array();       
                    
                    
                    $_TMP_RAM_DATA = [];
                    $_TMP_RAM_DATA["name"] = $pi->pi_name;
                    $_TMP_RAM_DATA["color"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    $_TMP_RAM_DATA["data"] = array();
                    
                    foreach($notifications as $notification) {                                                
                        if($notification->type === "cpu") {
                            array_push($_TMP_CPU_DATA["data"], array(
                                "x" => $notification->created_at,
                                "y" => $notification->value
                            ));
                        }

                        if($notification->type === "ram") {
                            array_push($_TMP_RAM_DATA["data"], array(
                                "x" => $notification->created_at,
                                "y" => $notification->value
                            ));
                        }
                    }

                    $maxCpuData = max($maxCpuData, count($_TMP_CPU_DATA["data"]));
                    $maxRamData = max($maxRamData, count($_TMP_RAM_DATA["data"]));   
                    
                    array_push($data["cpuUsage"], $_TMP_CPU_DATA);
                    array_push($data["ramUsage"], $_TMP_RAM_DATA);
                }

                
            }
            foreach ($data["cpuUsage"] as &$device) {
                $device["data"] = array_pad($device["data"], $maxCpuData, array(
                    "x" => Carbon::now(),
                    "y" => 0
                ));
            }
            $data["cpuUsage"] = json_encode($data["cpuUsage"]);

            foreach ($data["ramUsage"] as &$device) {
                $device["ramUsage"] = array_pad($device["data"], $maxRamData, array(
                    "x" => Carbon::now(),
                    "y" => 0
                ));
            }
            $data["ramUsage"] = json_encode($data["ramUsage"]);

            $data["storageUsage"] = json_encode($data["storageUsage"]);

            return view('livewire.pages.manage-dashboard.admin', compact("data"));
        }

        if($user->hasRole('subadmin')){            
            return view('livewire.pages.manage-dashboard.subadmin');
        }

    }

    public function getCpuUsage(Request $request, $hours) {
        $user = Auth::user();

        $rasberryPis = $user->raspberryPis;

        $cpuUsage = array();

        foreach($rasberryPis as $key => $pi) {            
            $maxCpuData = 0;

            switch($hours):
                case 1:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subHour())
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;
                case 3:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subHours(3))
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;                    
                case 24:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subDay())
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;
            endswitch;

            if(isset($notifications) && count($notifications) > 0) {
                $TMP_DATA = [];
                $TMP_DATA["name"] = $pi->pi_name;
                $TMP_DATA["color"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));;
                $TMP_DATA["data"] = array();                    
                foreach($notifications as $notification) {                                                
                    if($notification->type === "cpu") {
                        array_push($TMP_DATA["data"], array(
                            "x" => $notification->created_at,
                            "y" => $notification->value
                        ));
                    }
                }
                $maxCpuData = max($maxCpuData, count($TMP_DATA["data"]));   
                array_push($cpuUsage, $TMP_DATA);
            }

            
        }
        foreach ($cpuUsage as &$device) {
            $device["data"] = array_pad($device["data"], $maxCpuData, array(
                "x" => Carbon::now(),
                "y" => 0
            ));
        }
        $cpuUsage = json_encode($cpuUsage);


        return array(
            "success" => true,
            "data" => $cpuUsage
        );        

    }

    public function getRamUsage(Request $request, $hours) {
        $user = Auth::user();

        $rasberryPis = $user->raspberryPis;

        $ramUsage = array();

        foreach($rasberryPis as $key => $pi) {            
            $maxRamData = 0;

            switch($hours):
                case 1:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subHour())
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;
                case 3:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subHours(3))
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;                    
                case 24:
                    $notifications = RasberryPiNotification::where('rasberry_pi_id', $pi->id)
                        ->where('created_at', '>=', Carbon::now()->subDay())
                        ->orderBy('created_at', 'asc')
                        ->get();
                    break;
            endswitch;

            if(isset($notifications) && count($notifications) > 0) {
                $TMP_DATA = [];
                $TMP_DATA["name"] = $pi->pi_name;
                $TMP_DATA["color"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));;
                $TMP_DATA["data"] = array();                    
                foreach($notifications as $notification) {                                                
                    if($notification->type === "ram") {
                        array_push($TMP_DATA["data"], array(
                            "x" => $notification->created_at,
                            "y" => $notification->value
                        ));
                    }
                }
                $maxRamData = max($maxRamData, count($TMP_DATA["data"]));   
                array_push($ramUsage, $TMP_DATA);
            }

            
        }
        foreach ($ramUsage as &$device) {
            $device["data"] = array_pad($device["data"], $maxRamData, array(
                "x" => Carbon::now(),
                "y" => 0
            ));
        }
        $ramUsage = json_encode($ramUsage);


        return array(
            "success" => true,
            "data" => $ramUsage
        );        

    }
}
