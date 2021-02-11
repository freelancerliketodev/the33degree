<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operator_id',
        'transaction_id',
        'amount',
        'transaction_at',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
