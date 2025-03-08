<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ConsoleOwner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cover_id', 'additional_cover_id'];

    // Relationship to Consoles
    public function consoles()
    {
        return $this->hasMany(Console::class);
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

    public function getAdditionalCoverUrlAttribute()
    {
        $additionalCoverImage = Image::find($this->additional_cover_id);
        return $additionalCoverImage ? Storage::url($additionalCoverImage->file_path) : null;
    }
}
