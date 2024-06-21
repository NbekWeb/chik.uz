<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id', 'photo', 'name'];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
