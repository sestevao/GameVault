<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'file_name',
        'mime_type',
        'alt_text',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function console()
    {
        return $this->belongsTo(Console::class);
    }

    public function consoleOwner()
    {
        return $this->belongsTo(ConsoleOwner::class);
    }
}
