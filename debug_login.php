<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$npk = '11220079';
$user = User::where('npk', $npk)->first();

if ($user) {
    echo "User found:\n";
    echo "Name: " . $user->name . "\n";
    echo "NPK: " . $user->npk . "\n";
    echo "Dept: " . $user->department . "\n";
    echo "Role: " . $user->role . "\n";
} else {
    echo "User with NPK $npk not found.\n";
    $count = User::count();
    echo "Total users in DB: $count\n";
    $sample = User::whereNotNull('npk')->limit(5)->get();
    echo "Sample users with NPK:\n";
    foreach ($sample as $s) {
        echo "- " . $s->npk . " (" . $s->name . ")\n";
    }
}
