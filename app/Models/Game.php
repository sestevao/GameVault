<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_id',
        'additional_cover_id',
        'notes',
        'console_id',
        'genre_id',
    ];

    public function console()
    {
        return $this->belongsTo(Console::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
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
