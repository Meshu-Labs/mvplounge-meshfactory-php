<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Map Sandbox (Generic) ===' . PHP_EOL;

try {
    $factory = new \MvpLounge\MeshFactory\Element\ImageAndMultimedia\Map();

    $factory->addClass('generic-map_imageandmultimedia');

    $factory->addContent('generic-content-map_imageandmultimedia', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\ImageAndMultimedia\Map::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\ImageAndMultimedia\Map::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}