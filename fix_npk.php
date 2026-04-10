<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$affected = User::where(function($q) {
        $q->whereNull('npk')->orWhere('npk', '');
    })
    ->where('email', 'REGEXP', '^[0-9]+$')
    ->update(['npk' => DB::raw('email')]);

echo "Berhasil memperbarui $affected data NPK karyawan!\n";
