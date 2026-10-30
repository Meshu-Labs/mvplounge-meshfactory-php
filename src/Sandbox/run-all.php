<?php

declare(strict_types=1);

$php = 'C:/xampp_devops_test/php/php.exe';
$runners = [];

$iterator = new DirectoryIterator(__DIR__);

foreach ($iterator as $fileInfo) {
    if (!$fileInfo->isDir() || $fileInfo->isDot()) {
        continue;
    }

    $runner = $fileInfo->getPathname() . DIRECTORY_SEPARATOR . 'run-all.php';
    if (!is_file($runner)) {
        continue;
    }

    $runners[] = $runner;
}

sort($runners);

foreach ($runners as $runner) {
    echo str_repeat('=', 80) . PHP_EOL;
    $displayPath = str_replace('\\', '/', str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $runner));
    echo $displayPath . PHP_EOL;

    $cmd = sprintf('"%s" "%s"', $php, $runner);
    passthru($cmd, $code);

    if ($code !== 0) {
        echo 'Sandbox suite failed: ' . basename(dirname($runner)) . PHP_EOL;
        exit($code);
    }
}

echo str_repeat('=', 80) . PHP_EOL;
echo 'All sandbox suites executed.' . PHP_EOL;
