<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'updated_at',
        'current_time_id',
        'role',
        'email',
        'transaction',
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url', 'has_active_packet',
    ];

    public function packet()
    {
        return $this->hasOne(Packet::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function isAdmin()
    {
        return $this->role == 'ADMIN';
    }

    public function packetDetail()
    {
        if($this->transaction == null)
            return '-';

        $transaction = $this->transaction->where('user_id', $this->id)->where('status', 'SUCCESS')->orderBy('created_at', 'DESC')->get();
        if ($transaction != null && count($transaction) > 0) {
            return $this->transaction->packetLabel();
        } else {
            return '-';
        }
    }

    public function getHasActivePacketAttribute()
    {
        return $this->hasActivePacket();
    }

    public function hasActivePacket()
    {
        if($this->transaction == null)
            return false;

        return $this->transaction->where('pay_date', '>=', Carbon::now())->exists();
    }
}
