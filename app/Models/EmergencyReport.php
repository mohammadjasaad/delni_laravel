<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmergencyService;

class EmergencyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'reason',
    ];

    // ✅ العلاقة مع مركز الطوارئ
public function service()
{
    return $this->belongsTo(\App\Models\EmergencyService::class, 'emergency_service_id');
}

}
