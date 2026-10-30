<?php

declare(strict_types=1);

$php = 'C:/xampp_devops_test/php/php.exe';
$files = [];
$sandboxRoot = dirname(__DIR__);

if (!is_file($php)) {
    fwrite(STDERR, 'PHP binary not found: ' . $php . PHP_EOL);
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sandboxRoot, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $fileInfo) {
    if (!$fileInfo->isFile()) {
        continue;
    }

    $fileName = $fileInfo->getFilename();
    if (!str_ends_with($fileName, '-sandbox.php')) {
        continue;
    }

    $files[] = $fileInfo->getPathname();
}

sort($files);

if (count($files) === 0) {
    fwrite(STDERR, 'No sandbox scripts found under: ' . $sandboxRoot . PHP_EOL);
    exit(1);
}

echo 'DEBUG_RUN_ALL: ' . str_replace('\\', '/', __FILE__) . PHP_EOL;
echo 'DEBUG_SANDBOX_ROOT: ' . str_replace('\\', '/', $sandboxRoot) . PHP_EOL;
echo 'DEBUG_PHP: ' . $php . PHP_EOL;
echo 'DEBUG_TOTAL_SANDBOX_FILES: ' . count($files) . PHP_EOL;

echo str_repeat('-', 80) . PHP_EOL;
echo 'Preflight lint pass' . PHP_EOL;
foreach ($files as $file) {
    $lintCmd = sprintf('"%s" -l "%s"', $php, $file);
    exec($lintCmd, $lintOutput, $lintCode);
    if ($lintCode !== 0) {
        echo str_repeat('=', 80) . PHP_EOL;
        echo 'Lint failed: ' . str_replace('\\', '/', $file) . PHP_EOL;
        echo implode(PHP_EOL, $lintOutput) . PHP_EOL;
        exit($lintCode);
    }
}
echo 'Preflight lint pass complete.' . PHP_EOL;

foreach ($files as $file) {
    echo str_repeat('=', 80) . PHP_EOL;
    $displayPath = str_replace('\\', '/', str_replace($sandboxRoot . DIRECTORY_SEPARATOR, '', $file));
    echo $displayPath . PHP_EOL;

    $cmd = sprintf('"%s" "%s"', $php, $file);
    passthru($cmd, $code);

    if ($code !== 0) {
        echo 'Sandbox failed: ' . $displayPath . PHP_EOL;
        echo 'DEBUG_SINGLE: ' . str_replace('\\', '/', $file) . PHP_EOL;
        echo 'DEBUG_RUN_ALL: ' . str_replace('\\', '/', __FILE__) . PHP_EOL;
        exit($code);
    }
}

echo str_repeat('=', 80) . PHP_EOL;
echo 'All sandbox scripts executed.' . PHP_EOL;
