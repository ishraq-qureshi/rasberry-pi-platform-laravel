<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSetting;

class UserSettingController extends Controller
{
    function edit() {
        $user = Auth::user();

        $settings = UserSetting::where('user_id', $user->id)->get();

        $data = [
            "cpu_notification" => "",
            "ram_notification" => "",
            "temperature_notification" => "",
            "storage_notification" => ""
        ];

        foreach($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }

        return view('livewire.pages.manage-user-settings.edit', compact('data'));
    }

    function save (Request $request) {
        $request->validate([
            "cpu_notification" => "required",
            "ram_notification" => "required",
            "storage_notification" => "required",
            "temperature_notification" => "required"
        ]);

        $user = Auth::user();

        $cpu_notification = UserSetting::where(['user_id' => $user->id, 'key' => 'cpu_notification'])->first();
        
        if($cpu_notification) {
            $cpu_notification->value = $request->cpu_notification;
            $cpu_notification->save();
        } else {
            UserSetting::create(array(
                'key' => 'cpu_notification',
                'value' => $request->cpu_notification,
                'user_id' => $user->id,
            ));
        }

        $ram_notification = UserSetting::where(['user_id' => $user->id, 'key' => 'ram_notification'])->first();
        
        if($ram_notification) {
            $ram_notification->value = $request->ram_notification;
            $ram_notification->save();
        } else {
            UserSetting::create(array(
                'key' => 'ram_notification',
                'value' => $request->ram_notification,
                'user_id' => $user->id,
            ));
        }

        $storage_notification = UserSetting::where(['user_id' => $user->id, 'key' => 'storage_notification'])->first();
        
        if($storage_notification) {
            $storage_notification->value = $request->storage_notification;
            $storage_notification->save();
        } else {
            UserSetting::create(array(
                'key' => 'storage_notification',
                'value' => $request->storage_notification,
                'user_id' => $user->id,
            ));
        }

        $temperature_notification = UserSetting::where(['user_id' => $user->id, 'key' => 'temperature_notification'])->first();
        
        if($temperature_notification) {
            $temperature_notification->value = $request->temperature_notification;
            $temperature_notification->save();
        } else {
            UserSetting::create(array(
                'key' => 'temperature_notification',
                'value' => $request->temperature_notification,
                'user_id' => $user->id,
            ));
        }

        return redirect()->route('user-setting.edit')->with("success", "Record(s) saved successfully.");

    }

}
