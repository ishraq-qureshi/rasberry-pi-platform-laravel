<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'telephone',
        'billing_address',
        'postal_address',
        'company_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function raspberryPis()
    {
        return $this->hasManyThrough(RasberryPi::class, UserSubscription::class);
    }

    public function trialSubscription() {

        $subscription = $this->subscriptions;
        if(isset($subscription) && count($subscription) > 0) {
            return $subscription[0]->plan->is_trial;
        }

        return false;
    }

    public function subUsers()
    {
        return $this->hasMany(SubUser::class, 'parent_user_id');
    }

    public function subUser()
    {
        return $this->hasOne(SubUser::class, 'user_id');
    }

    public function subUserRasberryPi()
    {
        return $this->hasMany(UserRasberryPi::class, 'user_id');
    }

}
