<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Console extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cover_id', 'owner_id'];

    // Relationship to ConsoleOwner
    public function owner()
    {
        return $this->belongsTo(ConsoleOwner::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getCoverUrlAttribute()
    {
        $coverImage = Image::find($this->cover_id);
        return $coverImage ? Storage::url($coverImage->file_path) : null;
    }
}
