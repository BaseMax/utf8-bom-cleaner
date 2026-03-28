<?php
/**
 * Unicode Finder
 * Detects BOM and zero-width characters in files
 *
 * @license MIT
 * @copyright 2026 Seyyed Ali Mohammadiyeh (Max Base)
 */

declare(strict_types=1);

function hasInvalidUnicode(string $content): bool
{
    return (bool) preg_match('/^\xEF\xBB\xBF|[\x{200B}-\x{200D}\x{FEFF}]/u', $content);
}

function shouldScan(string $path): bool
{
    return preg_match('/\.(php|js|html|css)$/i', $path);
}

$directory = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS)
);

$total = 0;
$infected = 0;

foreach ($directory as $file) {
    if (!$file->isFile()) continue;

    $path = $file->getPathname();

    if (strpos($path, 'vendor') !== false) continue;

    if (!shouldScan($path)) continue;

    $total++;

    $content = file_get_contents($path);

    if ($content !== false && hasInvalidUnicode($content)) {
        echo "INVALID: {$path}" . PHP_EOL;
        $infected++;
    }
}

echo PHP_EOL;
echo "Scan complete." . PHP_EOL;
echo "Checked: {$total} files" . PHP_EOL;
echo "Infected: {$infected} files" . PHP_EOL;
