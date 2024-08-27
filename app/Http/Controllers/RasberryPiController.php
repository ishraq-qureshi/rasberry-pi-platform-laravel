<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RasberryPi;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscription;
use App\Models\RasberryPiAnalytics;
use App\Models\RasberryPiNotification;

class RasberryPiController extends Controller
{
    public function view (Request $request) {
        $rasberryPis = Auth::user()->raspberryPis;

        return view('livewire.pages.manage-rasberry-pi.view', compact('rasberryPis'));
    }

    public function create (Request $request) {

        $raspberryPis = Auth::user()->raspberryPis;
        $subscriptions = Auth::user()->subscriptions;
        
        if($subscriptions && count($subscriptions) > 0) {
            $allowedRasberryPi = $subscriptions[0]->plan->allowed_rasberry;                        
            if(count($raspberryPis) >= $allowedRasberryPi) {
                return redirect()->route('rasberry-pi.view')->with("error", "You had exceed limit of rasberry pi");
            }
        }
        return view('livewire.pages.manage-rasberry-pi.edit');
    }

    public function edit (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi.edit', compact('rasberryPi'));
    }

    public function delete (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi.delete', compact('rasberryPi'));
    }

    public function destroy (Request $request, $id) {
        RasberryPi::where('id', $id)->delete();
        return redirect()->route('rasberry-pi.view')->with("success", "Record(s) deleted successfully.");
    }

    public function save(Request $request) {
        
        $request->validate([
            "pi_name" => "required",
            "model" => "required"
        ]);

        $user = Auth::user();

        $subscription = UserSubscription::where([
            "user_id" => $user->id,                    
        ])->first();

        $data = array(
            "pi_name" => $request->pi_name,
            "model" => $request->model,
            "user_subscription_id" => $subscription->id
        );

        if($request->id) {
            $rasberryPi = RasberryPi::where("id", $request->id)->update($data);
        } else {
            $rasberryPi = RasberryPi::create($data);
        }

        return redirect()->route('rasberry-pi.view')->with("success", "Record(s) saved successfully.");

    }

    public function connect (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi.connect', compact('rasberryPi'));
    }

    public function postData(Request $request, $id) {
        $data = array(
            "serial_number" => $request->serial_number,
            "cpu_usage" => $request->cpu_usage,
            "ram_usage" => $request->ram_usage,
            "temperature" => $request->temperature,
            "model" => $request->model,
            "ip_address_lan" => $request->ip_address_lan,
            "ip_address_wlan" => $request->ip_address_wlan,
            "storage_usage" => $request->storage_usage,
            "last_update" => $request->last_update,
            "disk_usage_total" => $request->disk_usage_total,
            "disk_usage_used" => $request->disk_usage_used,
            "rasberry_pi_id" => $id,
        );

        $rasberryPiAnalytics = RasberryPiAnalytics::where('rasberry_pi_id', $id)->first();

        if($rasberryPiAnalytics) {
            $rasberryPiAnalytics->serial_number = $request->serial_number;
            $rasberryPiAnalytics->cpu_usage = $request->cpu_usage;
            $rasberryPiAnalytics->ram_usage = $request->ram_usage;
            $rasberryPiAnalytics->temperature = $request->temperature;
            $rasberryPiAnalytics->model = $request->model;
            $rasberryPiAnalytics->ip_address_lan = $request->ip_address_lan;
            $rasberryPiAnalytics->ip_address_wlan = $request->ip_address_wlan;
            $rasberryPiAnalytics->storage_usage = $request->storage_usage;
            $rasberryPiAnalytics->last_update = $request->last_update;
            $rasberryPiAnalytics->disk_usage_total = $request->disk_usage_total;
            $rasberryPiAnalytics->disk_usage_used = $request->disk_usage_used;

            $rasberryPiAnalytics->save();
        } else {
            RasberryPiAnalytics::create($data);
        }

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->cpu_usage),
                "type" => "cpu",
                "status" => $this->checkStatus(floatval($request->cpu_usage)),
            )
        );

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->temperature),
                "type" => "temperature",
                "status" => $this->checkStatus(floatval($request->temperature)),
            )
        );

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->ram_usage),
                "type" => "ram",
                "status" => $this->checkStatus(floatval($request->ram_usage)),
            )
        );

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->storage_usage),
                "type" => "storage",
                "status" => $this->checkStatus(floatval($request->storage_usage)),
            )
        );

        return true;
    }

    public function details (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi.details', compact('rasberryPi'));
    }

    function checkStatus ($value){
        if($value >= 0 && $value < 25) {
            return "ideal";
        } 
        else if($value >= 25 && $value < 75) {
            return "warning";
        } else if($value >= 75) {
            return "danger";
        }
    }

    // Data To Received
    // {'serial_number': 'b75d4c9862e2c8a7', 'cpu_usage': '0.0%', 'ram_usage': '6.4%', 'temperature': '44.1C', 'model': 'Raspberry Pi 5 Model B Rev 1.0\x00', 'ip_address_lan': '192.168.1.29', 'ip_address_wlan': '192.168.1.29', 'storage_usage': '9.35%', 'last_update': '2024-08-26 18:22:38', 'disk_usage_total': 62260461568, 'disk_usage.used': 5822255104}
}
