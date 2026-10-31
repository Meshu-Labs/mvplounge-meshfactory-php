<?php

declare(strict_types=1);

/**
 * Builds a Composer-installable artifact zip of the MeshFactory package from the working tree.
 *
 * The artifact mirrors the package export whitelist (composer.json + src/Labs/MeshFactory) and
 * injects a "version" into the packaged composer.json, which Composer's "artifact" repository type
 * requires. Sandbox, docs, scripts and CI files are never packaged.
 *
 * Usage:
 *   php scripts/build-artifact.php [--version=dev-local] [--out=build]
 *
 * Examples:
 *   php scripts/build-artifact.php --version=0.9.0-alpha1
 *   php scripts/build-artifact.php --version=dev-local --out=C:/_src/ps-xamppire/.tmp/artifacts
 */

if (!class_exists(ZipArchive::class)) {
    fwrite(STDERR, 'The PHP zip extension is required.' . PHP_EOL);
    exit(1);
}

$root = dirname(__DIR__);
$options = getopt('', ['version::', 'out::']);
$version = is_string($options['version'] ?? null) && $options['version'] !== '' ? $options['version'] : 'dev-local';
$outDir = is_string($options['out'] ?? null) && $options['out'] !== '' ? $options['out'] : $root . '/build';

if (!preg_match('/^(dev-[A-Za-z0-9._\/-]+|\d+\.\d+\.\d+(?:-(?:alpha|beta|RC|dev|patch|p|pl)\.?\d*)?)$/', $version)) {
    fwrite(STDERR, 'Unsupported version format: ' . $version . PHP_EOL);
    exit(1);
}

$composer = json_decode((string) file_get_contents($root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
$composer['version'] = $version;

$files = [];
$libRoot = $root . '/src/Labs/MeshFactory';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($libRoot, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if ($file->isFile()) {
        $files[str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1))] = $file->getPathname();
    }
}
ksort($files);

if (!is_dir($outDir) && !mkdir($outDir, 0777, true) && !is_dir($outDir)) {
    fwrite(STDERR, 'Cannot create output directory: ' . $outDir . PHP_EOL);
    exit(1);
}

$target = rtrim(str_replace('\\', '/', $outDir), '/') . '/mvplounge-meshfactory-' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $version) . '.zip';
if (is_file($target)) {
    unlink($target);
}

$zip = new ZipArchive();
if ($zip->open($target, ZipArchive::CREATE) !== true) {
    fwrite(STDERR, 'Cannot create archive: ' . $target . PHP_EOL);
    exit(1);
}

$zip->addFromString('composer.json', json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
foreach ($files as $entry => $path) {
    $zip->addFile($path, $entry);
}
$zip->close();

echo 'ARTIFACT ' . $target . PHP_EOL;
echo 'VERSION  ' . $version . PHP_EOL;
echo 'ENTRIES  ' . (count($files) + 1) . PHP_EOL;
echo 'SHA256   ' . hash_file('sha256', $target) . PHP_EOL;
