<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MallBanner extends Model
{
    protected $fillable = [
        'title',
        'image_desktop',
        'link',
    ];
}
