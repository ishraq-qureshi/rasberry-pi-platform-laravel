<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RasberryPiAnalytics extends Model
{
    use HasFactory;

    protected $fillable = ["serial_number", "cpu_usage", "ram_usage", "temperature", "model", "ip_address_lan", "ip_address_wlan", "storage_usage", "last_update", "disk_usage_total", "disk_usage_used", "rasberry_pi_id"];
    
    public function raspberryPi()
    {
        return $this->belongsTo(RaspberryPi::class, 'rasberry_pi_id');
    }
}
