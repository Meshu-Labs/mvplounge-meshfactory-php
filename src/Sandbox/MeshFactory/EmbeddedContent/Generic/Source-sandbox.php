<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Source Sandbox (Generic) ===' . PHP_EOL;

try {
    $factory = new \MvpLounge\MeshFactory\Element\EmbeddedContent\Source();

    $factory->addClass('generic-source_embeddedcontent');

    $factory->addContent('generic-content-source_embeddedcontent', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\EmbeddedContent\Source::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\EmbeddedContent\Source::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}