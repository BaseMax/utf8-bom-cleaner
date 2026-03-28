<?php
/**
 * Unicode Resolver
 * Removes BOM and zero-width characters from files
 *
 * @license MIT
 * @copyright 2026 Seyyed Ali Mohammadiyeh (Max Base)
 */

declare(strict_types=1);

function cleanUnicode(string $content): string
{
    // BOM
    $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

    // zero-width
    $content = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $content);

    return $content;
}

function shouldProcess(string $path): bool
{
    return preg_match('/\.(php|js|html|css)$/i', $path);
}

$directory = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS)
);

$total = 0;
$fixed = 0;

foreach ($directory as $file) {
    if (!$file->isFile()) continue;

    $path = $file->getPathname();

    if (strpos($path, 'vendor') !== false) continue;

    if (!shouldProcess($path)) continue;

    $total++;

    $original = file_get_contents($path);
    if ($original === false) continue;

    $cleaned = cleanUnicode($original);

    if ($original !== $cleaned) {
        file_put_contents($path, $cleaned);
        echo "FIXED: {$path}" . PHP_EOL;
        $fixed++;
    }
}

echo PHP_EOL;
echo "Done." . PHP_EOL;
echo "Checked: {$total} files" . PHP_EOL;
echo "Fixed: {$fixed} files" . PHP_EOL;
