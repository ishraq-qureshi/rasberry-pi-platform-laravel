<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class RasberryPi extends Model
{
    use HasFactory;

    protected $fillable = ["pi_name", "model", "user_subscription_id", "rasberry_pi_model_id"];

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    public function analytics()
    {
        return $this->hasOne(RasberryPiAnalytics::class, 'rasberry_pi_id');
    }

    public function model()
    {        
        return $this->belongsTo(RasberryPiModel::class, 'rasberry_pi_model_id');
    }

    public function token()
    {
        return $this->hasOne(RasberryPiToken::class, 'id');
    }

    public function notifications()
    {
        return $this->hasMany(RasberryPiNotification::class, 'rasberry_pi_id');
    }

    public function isOnline()
    {
        $analytics = $this->analytics;
        
        if ($analytics) {
            $lastUpdate = Carbon::parse($analytics->updated_at);
            $currentTime = Carbon::now();
            $tenMinutesAgo = $currentTime->copy()->subMinutes(10);

            // Check if lastUpdate is between 10 minutes ago and now
            return $lastUpdate->between($tenMinutesAgo, $currentTime);
        }

        return false;
}

}
