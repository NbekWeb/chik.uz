<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'photo', 'photo_link', 'url_link'];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
