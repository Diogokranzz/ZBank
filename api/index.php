<?php


if (getenv('APP_DEBUG') === 'true' || getenv('APP_DEBUG') === '1') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    
   
    error_log('[Vercel] Starting Laravel application bootstrap');
}


$_ENV['APP_STORAGE'] = '/tmp/storage';


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

require __DIR__ . '/../public/index.php';
