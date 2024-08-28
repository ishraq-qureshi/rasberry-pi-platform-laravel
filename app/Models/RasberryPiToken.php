<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasberryPiToken extends Model
{
    use HasFactory;

    protected $fillable = ["rasberry_pi_id", "token"];
}
