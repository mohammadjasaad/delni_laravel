<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpCode extends Model
{
    protected $fillable = ['phone','code','expires_at'];

    public $timestamps = true;

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
