<?php

/**
 * Copies vendored front-end assets from resources/ into public/.
 *
 * Replaces the former webpack.mix.js / laravel-mix copy step. All source
 * files here are pre-built, static vendor assets checked into the repo, so
 * no compilation/bundling is needed - just staging them into public/.
 */
$root = dirname(__DIR__);

function copy_file(string $root, string $from, string $toDir): void
{
    $target = $root.'/'.$toDir;
    if (! is_dir($target)) {
        mkdir($target, 0755, true);
    }
    copy($root.'/'.$from, $target.'/'.basename($from));
}

function copy_dir(string $root, string $from, string $to): void
{
    $source = $root.'/'.$from;
    $target = $root.'/'.$to;

    if (! is_dir($target)) {
        mkdir($target, 0755, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $destination = $target.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
        if ($item->isDir()) {
            if (! is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
        } else {
            copy($item, $destination);
        }
    }
}

$cssFiles = [
    'resources/plugins/fontawesome-free/css/all.min.css',
    'resources/css/adminlte.min.css',
    'resources/css/custom.css',
    'resources/css/daterangepicker.css',
];

foreach ($cssFiles as $file) {
    copy_file($root, $file, 'public/css');
}

$jsFiles = [
    'resources/plugins/jquery/jquery.min.js',
    'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/js/adminlte.min.js',
    'resources/js/daterangepicker.js',
    'resources/js/moment.min.js',
];

foreach ($jsFiles as $file) {
    copy_file($root, $file, 'public/js');
}

copy_dir($root, 'resources/plugins/fontawesome-free/webfonts', 'public/webfonts');
copy_dir($root, 'resources/img', 'public/img');

echo "Assets copied to public/.\n";
