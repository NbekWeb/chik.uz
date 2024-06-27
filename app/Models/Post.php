<?php

namespace App\Models;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'category_id',
        'title',
        'slug',
        'body',
        'price',
        'is_active',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Attachment::class, 'attachment');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function complaint()
    {
        return $this->hasMany(Complaint::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function approvedReviews()
    {
        return $this->reviews()->where('status', 1);
    }
    public function overalReview()
    {
        return $this->approvedReviews()->avg('star');
    }
}
