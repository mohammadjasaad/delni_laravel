#!/bin/bash

echo "🚧 بدء عملية تصحيح هيكل مشروع Laravel ..."

# 1. التحقق من وجود ملف artisan
if [ ! -f artisan ]; then
  echo "❌ أنت لست في مجلد مشروع Laravel. الرجاء الدخول إلى مجلد المشروع أولاً."
  exit 1
fi

# 2. التأكد من وجود المجلدات الأساسية
mkdir -p resources/views/dashboard
mkdir -p resources/views/test
mkdir -p storage/framework/views

# 3. تعيين الأذونات الصحيحة للمجلدات
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER .

# 4. حذف ملفات الكاش المؤقتة
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 5. إنشاء صفحة عرض test بسيطة
echo '@extends("layouts.app")
@section("content")
<h1>✔️ Laravel يعمل بشكل صحيح</h1>
@endsection' > resources/views/test/index.blade.php

# 6. تعديل ملف routes/web.php لإضافة test-view
echo 'Route::get("/test-view", function () {
    return view("test.index");
});' >> routes/web.php

# 7. تشغيل السيرفر
echo "🚀 جاري تشغيل السيرفر..."
php artisan serve
