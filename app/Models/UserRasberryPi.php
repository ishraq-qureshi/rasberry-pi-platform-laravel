<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRasberryPi extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "rasberry_pi_id"];


    public function user (){
        return $this->belongsTo(User::class, "user_id");
    }

    public function rasberry_pi (){
        return $this->belongsTo(RasberryPI::class, "rasberry_pi_id");
    }

}
