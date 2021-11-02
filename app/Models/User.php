<?php

namespace App\Models;

use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'discord_id',
        'email',
        'username',
        'discriminator',
        'refresh_token',
        'type',
        'ram_balance',
        'disk_balance',
        'cpu_balance',
        'slot_balance',
        'coin_balance',
        'panel_acc',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'refresh_token',
    ];

    protected $dates = [
        'last_login'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
