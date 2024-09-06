<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RasberryPi;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscription;
use App\Models\UserRasberryPi;
use App\Models\RasberryPiAnalytics;
use App\Models\RasberryPiNotification;
use App\Models\RasberryPiModel;
use App\Models\RasberryPiToken;
use Illuminate\Support\Str;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;


class RasberryPiController extends Controller
{
    public function view (Request $request) {
        $user = Auth::user();
        $rasberryPis = $user->raspberryPis;

        if($user->hasRole('subadmin')){
            $rasberryPis = $user->subUserRasberryPi;    
        }
        
        return view('livewire.pages.manage-rasberry-pi.view', compact('rasberryPis'));
    }

    public function create (Request $request) {

        $raspberryPis = Auth::user()->raspberryPis;
        $subscriptions = Auth::user()->subscriptions;
        $models = RasberryPiModel::all();
        
        if($subscriptions && count($subscriptions) > 0) {
            $allowedRasberryPi = $subscriptions[0]->plan->allowed_rasberry;                        
            if(count($raspberryPis) >= $allowedRasberryPi) {
                return redirect()->route('rasberry-pi.view')->with("error", "You had exceed limit of rasberry pi");
            }
        }
        return view('livewire.pages.manage-rasberry-pi.edit', compact('models'));
    }

    public function edit (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        $models = RasberryPiModel::all();
        return view('livewire.pages.manage-rasberry-pi.edit', compact('rasberryPi', 'models'));
    }

    public function delete (Request $request, $id) {
        $rasberryPi = RasberryPi::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi.delete', compact('rasberryPi'));
    }

    public function destroy (Request $request, $id) {
        UserRasberryPi::where(["rasberry_pi_id" => $id])->delete();
        RasberryPi::where('id', $id)->delete();
        return redirect()->route('rasberry-pi.view')->with("success", "Record(s) deleted successfully.");
    }

    public function save(Request $request) {
        
        $request->validate([
            "pi_name" => "required",
            "rasberry_pi_model_id" => "required"
        ]);

        $user = Auth::user();

        $subscription = UserSubscription::where([
            "user_id" => $user->id,
        ])->first();

        if($user->hasRole('subadmin')):
            $subscription = UserSubscription::where([
                "user_id" => $user->subUser->parentUser->id,
            ])->first();
        endif;

        $data = array(
            "pi_name" => $request->pi_name,
            "rasberry_pi_model_id" => $request->rasberry_pi_model_id,
            "user_subscription_id" => $subscription->id
        );

        if($request->id) {
            $rasberryPi = RasberryPi::where("id", $request->id)->update($data);
            
        } else {
            $rasberryPi = RasberryPi::create($data);
            RasberryPiToken::create(array(
                'rasberry_pi_id' => $rasberryPi->id,
                'token' => Str::uuid()
            ));

            UserRasberryPi::create(array(
                "user_id" => $user->id,
                "rasberry_pi_id" => $rasberryPi->id,
            ));
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

        $user = Auth::user();
        $rasberryPi = RasberryPi::where('id', $id)->first();

        $details = [
            'customer_name' => $user->name,
            'device_name' => $rasberryPi->pi_name,
        ];

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->cpu_usage),
                "type" => "cpu",
                "status" => $this->checkStatus(floatval($request->cpu_usage)),
            )
        );
        

        if($this->checkStatus(floatval($request->cpu_usage)) === "danger") {     
            $details['data'] = array(
                "key" => "CPU Usage",
                "value" => $request->cpu_usage
            );       
            Mail::to($user->email)->send(new NotificationMail($details));
        }

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->temperature),
                "type" => "temperature",
                "status" => $this->checkStatus(floatval($request->temperature)),
            )
        );

        if($this->checkStatus(floatval($request->temperature)) === "danger") {     
            $details['data'] = array(
                "key" => "Temperature",
                "value" => $request->temperature
            );       
            Mail::to($user->email)->send(new NotificationMail($details));
        }

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->ram_usage),
                "type" => "ram",
                "status" => $this->checkStatus(floatval($request->ram_usage)),
            )
        );

        if($this->checkStatus(floatval($request->ram_usage)) === "danger") {     
            $details['data'] = array(
                "key" => "Ram Usage",
                "value" => $request->ram_usage
            );       
            Mail::to($user->email)->send(new NotificationMail($details));
        }

        RasberryPiNotification::create(
            array(
                "rasberry_pi_id" => $id,
                "value" => floatval($request->storage_usage),
                "type" => "storage",
                "status" => $this->checkStatus(floatval($request->storage_usage)),
            )
        );

        if($this->checkStatus(floatval($request->storage_usage)) === "danger") {     
            $details['data'] = array(
                "key" => "Storage",
                "value" => $request->storage_usage
            );       
            Mail::to($user->email)->send(new NotificationMail($details));
        }

        

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

    public function setup(Request $request, $token) {
        $scriptPath = storage_path('app/public/scripts/setup-rasberry-pi.py');
        
        if (!file_exists($scriptPath)) {
            return response()->json(['error' => 'Python script not found'], 404);
        }

        $rasberryPiToken = RasberryPiToken::where('token', $token)->first();
        
        if($rasberryPiToken) {
            $pythonCode = file_get_contents($scriptPath);
            $url = env('APP_URL') . '/post-rasberry-data/' . $rasberryPiToken->rasberry_pi_id;

            $pythonCode = str_replace(
                ['{{ DYNAMIC_URL }}'], 
                [$url], 
                $pythonCode
            );

            $script = <<<EOD
#!/bin/bash

# Ensure the desired directory exists
mkdir -p /home/ishraq/Desktop/pi/scripts

# Write the Python script (connection.py) dynamically
cat << 'EOF' > /home/ishraq/Desktop/pi/scripts/connection.py
$pythonCode
EOF

# Create the shell script to run connection.py every 5 seconds
cat << 'EOF' > /home/pi/scripts/run_connection.sh
#!/bin/bash
while true
do
  python3 /home/pi/scripts/connection.py
  sleep 5
done
EOF

# Make the run_connection.sh script executable
chmod +x /home/pi/scripts/run_connection.sh

# Add a cron job to run the script at boot
(crontab -l 2>/dev/null; echo "@reboot /home/pi/scripts/run_connection.sh") | crontab -

# Reboot the Raspberry Pi
sudo reboot
EOD;

    // Return the script as a response with the correct content type
    return response($script, 200)
                ->header('Content-Type', 'application/x-sh');
        }

        return response()->json(['error' => 'Something went wrong, please try again'], 500);



    }

    // Data To Received
    // {'serial_number': 'b75d4c9862e2c8a7', 'cpu_usage': '0.0%', 'ram_usage': '6.4%', 'temperature': '44.1C', 'model': 'Raspberry Pi 5 Model B Rev 1.0\x00', 'ip_address_lan': '192.168.1.29', 'ip_address_wlan': '192.168.1.29', 'storage_usage': '9.35%', 'last_update': '2024-08-26 18:22:38', 'disk_usage_total': 62260461568, 'disk_usage.used': 5822255104}
}
