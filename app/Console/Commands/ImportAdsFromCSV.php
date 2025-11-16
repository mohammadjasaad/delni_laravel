<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;
use League\Csv\Reader;
use Illuminate\Support\Str;

class ImportAdsFromCSV extends Command
{
    protected $signature = 'ads:import';
    protected $description = 'Import ads from storage/app/doushesh_import.csv into ads table';

    public function handle()
    {
        $filePath = storage_path('app/doushesh_import.csv');

        if (!file_exists($filePath)) {
            $this->error("❌ ملف doushesh_import.csv غير موجود داخل storage/app/");
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $count = 0;

        foreach ($records as $row) {

            // ✅ السعر
            $rawPrice = $row['price'] ?? '';
            $cleanPrice = preg_replace('/[^0-9]/', '', $rawPrice);
            $cleanPrice = $cleanPrice !== '' ? (int)$cleanPrice : 0;

            // ✅ تحسين المدينة (منع JSON / النص الطويل)
            $city = $row['city'] ?? '';
            if (strlen($city) > 50 || str_contains($city, '{') || str_contains($city, '[')) {
                $city = ''; // تجاهل القيم الغريبة
            } else {
                $city = mb_substr($city, 0, 50);
            }

            Ad::create([
                'title' => mb_substr($row['title'] ?? '', 0, 250),
                'description' => $row['description'] ?? '',
                'price' => $cleanPrice,
                'city' => $city,
                'category' => $row['category'] ?? 'other',
                'phone' => preg_replace('/[^0-9\+]/', '', $row['phone'] ?? ''),
                'source' => $row['source'] ?? 'منقول',
                'user_id' => 1,
                'images' => json_encode([]),
                'slug' => Str::slug(($row['title'] ?? '') . '-' . uniqid()),
                'is_featured' => 0,
                'status' => 'published',
            ]);

            $count++;
        }

        $this->info("✅ تم استيراد $count إعلان بنجاح!");
    }
}
