<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'users:' . \App\Models\User::count() . PHP_EOL;
echo 'services:' . \App\Models\Service::count() . PHP_EOL;
echo 'orders:' . \App\Models\Order::count() . PHP_EOL;
echo 'payments:' . \App\Models\Payment::count() . PHP_EOL;
echo 'reviews:' . \App\Models\Review::count() . PHP_EOL;
echo 'chats:' . \App\Models\Chat::count() . PHP_EOL;
