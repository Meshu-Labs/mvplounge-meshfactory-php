<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Caption Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\TableContent\Caption();
    $params = [
        'id' => 'el_id_caption_tablecontent',
        'class' => 'el-class-caption_tablecontent',
        'title' => 'Element title caption_tablecontent',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addContent('factory-content-caption_tablecontent', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\TableContent\Caption::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\TableContent\Caption::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);

    #endregion
}