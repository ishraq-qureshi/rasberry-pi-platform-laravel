<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSupportTicket extends Model
{
    use HasFactory;

    protected $fillable = ["title", "message", "user_id", "parent_id", "title"];


    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
