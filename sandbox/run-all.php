<?php

declare(strict_types=1);

$php = 'C:/xampp_devops_test/php/php.exe';
$files = glob(__DIR__ . '/*-sandbox.php');

sort($files);

foreach ($files as $file) {
    echo str_repeat('=', 80) . PHP_EOL;
    echo basename($file) . PHP_EOL;

    $cmd = sprintf('"%s" "%s"', $php, $file);
    passthru($cmd, $code);

    if ($code !== 0) {
        echo 'Sandbox failed: ' . basename($file) . PHP_EOL;
        exit($code);
    }
}

echo str_repeat('=', 80) . PHP_EOL;
echo 'All sandbox scripts executed.' . PHP_EOL;
