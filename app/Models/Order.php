<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'status',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
