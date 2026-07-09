<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "UserPost count: " . \App\Models\UserPost::count() . "\n";
echo "User count: " . \App\Models\User::count() . "\n";
echo "BreakingNews count: " . \App\Models\BreakingNews::count() . "\n";
echo "PhotoGallery count: " . \App\Models\PhotoGallery::count() . "\n";
echo "InstagramVideo count: " . \App\Models\InstagramVideo::count() . "\n";

echo "Advertisement count: " . \App\Models\Advertisement::count() . "\n";
$ads = \App\Models\Advertisement::all();
foreach ($ads as $ad) {
    echo "ID: {$ad->id} | Name: {$ad->name} | Status: {$ad->status} | Image URL: {$ad->image_url}\n";
}
