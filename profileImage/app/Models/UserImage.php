<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserImage extends Model
{
    protected $table = 'user_images';

    protected $fillable = [
        'user_id',
        'path',
    ];

    public function getPathAttribute($value)
    {
        return Storage::temporaryUrl(
            $value, now()->addMinutes(60)
        );
    }
}
