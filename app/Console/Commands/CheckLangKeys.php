<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLangKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:check {lang1=ar} {lang2=en}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check that two language files (messages.php) have identical keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lang1 = $this->argument('lang1');
        $lang2 = $this->argument('lang2');

        $file1 = resource_path("lang/{$lang1}/messages.php");
        $file2 = resource_path("lang/{$lang2}/messages.php");

        if (!file_exists($file1) || !file_exists($file2)) {
            $this->error("❌ One of the files does not exist: {$file1} or {$file2}");
            return 1;
        }

        $arr1 = include $file1;
        $arr2 = include $file2;

        $flatten = function ($array, $prefix = '') use (&$flatten) {
            $keys = [];
            foreach ($array as $key => $value) {
                $fullKey = $prefix ? $prefix . '.' . $key : $key;
                if (is_array($value)) {
                    $keys = array_merge($keys, $flatten($value, $fullKey));
                } else {
                    $keys[] = $fullKey;
                }
            }
            return $keys;
        };

        $keys1 = $flatten($arr1);
        $keys2 = $flatten($arr2);

        $missingIn2 = array_diff($keys1, $keys2);
        $missingIn1 = array_diff($keys2, $keys1);

        if (empty($missingIn1) && empty($missingIn2)) {
            $this->info("✅ {$lang1} and {$lang2} have identical keys!");
        } else {
            if (!empty($missingIn2)) {
                $this->warn("⚠️ Keys missing in {$lang2}:");
                foreach ($missingIn2 as $key) {
                    $this->line("   - {$key}");
                }
            }
            if (!empty($missingIn1)) {
                $this->warn("⚠️ Keys missing in {$lang1}:");
                foreach ($missingIn1 as $key) {
                    $this->line("   - {$key}");
                }
            }
        }

        return 0;
    }
}
