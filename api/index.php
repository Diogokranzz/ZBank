<?php


if (getenv('APP_DEBUG') === 'true' || getenv('APP_DEBUG') === '1') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    
   
    error_log('[Vercel] Starting Laravel application bootstrap');
}


$_ENV['APP_STORAGE'] = '/tmp/storage';


$bootstrapCache = '/tmp/bootstrap-cache';
if (!is_dir($bootstrapCache)) {
    mkdir($bootstrapCache, 0755, true);
    error_log("[Vercel] Created bootstrap cache directory: {$bootstrapCache}");
}


$bootstrapCacheDir = $bootstrapCache . '/cache';
if (!is_dir($bootstrapCacheDir)) {
    mkdir($bootstrapCacheDir, 0755, true);
    error_log("[Vercel] Created bootstrap cache/cache directory: {$bootstrapCacheDir}");
}

$_ENV['APP_BOOTSTRAP_CACHE'] = $bootstrapCache;

$storagePath = '/tmp/storage';
$directories = [
    $storagePath,
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/app',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
            error_log("[Vercel] Failed to create directory: {$dir}");
        } else {
            error_log("[Vercel] Created directory: {$dir}");
        }
    }
}


$cachedFiles = [
    __DIR__ . '/../bootstrap/cache/packages.php' => $bootstrapCache . '/packages.php',
    __DIR__ . '/../bootstrap/cache/services.php' => $bootstrapCache . '/services.php',
];

foreach ($cachedFiles as $source => $dest) {
    if (file_exists($source) && !file_exists($dest)) {
        copy($source, $dest);
        error_log("[Vercel] Copied cache file: " . basename($source));
    }
}

require __DIR__ . '/../public/index.php';
