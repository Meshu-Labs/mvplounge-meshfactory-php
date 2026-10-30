<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

echo '=== SelectOptions Sandbox ===' . PHP_EOL;

try {
    $factory = new \MvpLounge\MeshFactory\Element\Field\SelectOptions([]);

    if (method_exists($factory, 'getFactoryModel')) {
        echo '-- getFactoryModel() --' . PHP_EOL;
        print_r($factory->getFactoryModel());
    }

    if (method_exists($factory, 'compile')) {
        echo '-- compile() --' . PHP_EOL;
        print_r($factory->compile());
    }

    if (method_exists($factory, 'string')) {
        echo '-- string() --' . PHP_EOL;
        var_dump($factory->string());
    }
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}