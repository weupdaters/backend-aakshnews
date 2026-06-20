<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Boot Laravel kernel
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Calling getYouTubeChannelVideos('en')...\n";
$videos = getYouTubeChannelVideos('en');

print_r($videos);
