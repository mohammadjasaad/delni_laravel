<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiOrder extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     * ⚠️ أبقينا كل الحقول الموجودة لديك كما هي + أضفنا status_changed_at (اختياري إن كان العمود موجوداً)
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'driver_id',

        // إحداثيات الالتقاط والتسليم (بحسب تسميتك الحالية)
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',

        // معلومات الرحلة المحسوبة
        'distance_km',
        'duration_min',
        'cost',
        'status',

        // حقول إضافية موجودة في جدولك
        'estimated_fare',
        'pickup_address',
        'dropoff_address',
        'destination_name',

        // اختياري: طابع زمني لتغيير الحالة (إن كان العمود موجوداً في الجدول)
        'status_changed_at',
    ];

    /**
     * التحويلات (Casts)
     */
    protected $casts = [
        'pickup_latitude'   => 'float',
        'pickup_longitude'  => 'float',
        'dropoff_latitude'  => 'float',
        'dropoff_longitude' => 'float',
        'distance_km'       => 'float',
        'duration_min'      => 'integer',
        'estimated_fare'    => 'float',
        'status_changed_at' => 'datetime',
    ];

    /**
     * ثوابت الحالات الموحّدة للطلبات
     */
    public const STATUS_PENDING   = 'pending';
    public const STATUS_ACCEPTED  = 'accepted';
    public const STATUS_EN_ROUTE  = 'en_route';
    public const STATUS_STARTED   = 'started';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * العلاقات
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function user()
    {
        // في حال كان لديك موديل User افتراضي
        return $this->belongsTo(User::class);
    }

    /**
     * دوال مساعدة للحالة
     */

    // تعيين الحالة مع تسجيل وقت التغيير (إن توفر العمود في الجدول)
    public function setStatus(string $status): void
    {
        $this->status = $this->normalizeStatus($status);
        // لو كان لديك عمود status_changed_at سيخزن الوقت، وإن لم يكن موجودًا لن يؤثر ذلك.
        if ($this->isFillable('status_changed_at')) {
            $this->status_changed_at = now();
        }
    }

    // إرجاع حالة موحدّة حتى لو تم تمرير نص عربي
    public function normalizeStatus(string $status): string
    {
        $status = trim(mb_strtolower($status));

        // دعم بعض الألفاظ العربية الشائعة
        $map = [
            'قيد الانتظار' => self::STATUS_PENDING,
            'مقبول'       => self::STATUS_ACCEPTED,
            'في الطريق'    => self::STATUS_EN_ROUTE,
            'بدأت'         => self::STATUS_STARTED,
            'بدأ'          => self::STATUS_STARTED,
            'مكتمل'       => self::STATUS_COMPLETED,
            'منتهي'        => self::STATUS_COMPLETED,
            'أُلغي'        => self::STATUS_CANCELLED,
            'ملغي'         => self::STATUS_CANCELLED,
            'الغاء'        => self::STATUS_CANCELLED,
        ];

        if (isset($map[$status])) {
            return $map[$status];
        }

        // إن كانت أصلاً إحدى القيم الإنجليزية المعتمدة
        $allowed = [
            self::STATUS_PENDING,
            self::STATUS_ACCEPTED,
            self::STATUS_EN_ROUTE,
            self::STATUS_STARTED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];

        return in_array($status, $allowed, true) ? $status : self::STATUS_PENDING;
    }

    // اعتبارات "نشِط" (رحلة جارية)
    public function isActive(): bool
    {
        return in_array($this->status, [
            self::STATUS_ACCEPTED,
            self::STATUS_EN_ROUTE,
            self::STATUS_STARTED,
        ], true);
    }

    /**
     * سكوبات عملية للاستعلام
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $this->normalizeStatus($status));
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_ACCEPTED,
            self::STATUS_EN_ROUTE,
            self::STATUS_STARTED,
        ]);
    }

    /**
     * ملحقات مفيدة للإحداثيات (بدون تغيير مخرجات JSON افتراضيًا)
     * يمكن استخدامها في الواجهات: $order->pickup_point و $order->dropoff_point
     */
    public function getPickupPointAttribute(): ?array
    {
        if ($this->pickup_latitude === null || $this->pickup_longitude === null) {
            return null;
        }
        return [
            'lat' => (float) $this->pickup_latitude,
            'lng' => (float) $this->pickup_longitude,
        ];
    }

    public function getDropoffPointAttribute(): ?array
    {
        if ($this->dropoff_latitude === null || $this->dropoff_longitude === null) {
            return null;
        }
        return [
            'lat' => (float) $this->dropoff_latitude,
            'lng' => (float) $this->dropoff_longitude,
        ];
    }
}
