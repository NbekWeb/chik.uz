<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;
    protected $fillable = [
        'click_trans_id',
        'service_id',
        'click_paydoc_id',
        'merchant_trans_id',
        'amount',
        'action',
        'sign_time',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
