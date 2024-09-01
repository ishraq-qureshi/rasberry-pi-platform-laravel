<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasberryPiNotification extends Model
{
    use HasFactory;

    protected $fillable = ["rasberry_pi_id", "value", "type", "status"];

    public function rasberryPi()
    {
        return $this->belongsTo(RasberryPi::class, 'rasberry_pi_id');
    }
}
