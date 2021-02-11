<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'name',
        'created_at',
        'updated_at',
        "stripe_id",
        "card_brand",
        "card_last_four",
        "trial_ends_at",
        "email_verified_at"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getBalance(){
        if(!$this->balance){
            return 0.0;
        }
        return $this->balance;
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'DESC');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->orderBy('id', 'DESC');
    }
}
