<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;
    protected $fillable = [
        'click_trans_id',
        'click_paydoc_id',
        'amount',
        'sign_time',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
