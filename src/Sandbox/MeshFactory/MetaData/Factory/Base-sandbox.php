<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Base Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\MetaData\Base();
    $params = [
        'id' => 'el_id_base_metadata',
        'class' => 'el-class-base_metadata',
        'title' => 'Element title base_metadata',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addHref('/metadata/resource')
        ->addRel('stylesheet')
        ->addHreflang('en')
        ->addMedia('screen')
        ->addReferrerpolicy('origin')
        ->addType('text/css')
        ->addName('metadata_name')
        ->addAs('style')
        ->addIntegrity('sha256-test')
        ->addCrossorigin('anonymous')
        ->addContent('factory-content-base_metadata', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\MetaData\Base::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\MetaData\Base::class . PHP_EOL;
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