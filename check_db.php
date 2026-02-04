<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Units: " . (\Illuminate\Support\Facades\Schema::hasTable('units') ? 'YES' : 'NO') . "\n";
echo "ArsipMusnah: " . (\Illuminate\Support\Facades\Schema::hasTable('arsip_musnah') ? 'YES' : 'NO') . "\n";
