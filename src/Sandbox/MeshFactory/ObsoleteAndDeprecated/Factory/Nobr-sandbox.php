<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Nobr Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\ObsoleteAndDeprecated\Nobr();
    $params = [
        'id' => 'el_id_nobr_obsoleteanddeprecated',
        'class' => 'el-class-nobr_obsoleteanddeprecated',
        'title' => 'Element title nobr_obsoleteanddeprecated',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addContent('factory-content-nobr_obsoleteanddeprecated', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\ObsoleteAndDeprecated\Nobr::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\ObsoleteAndDeprecated\Nobr::class . PHP_EOL;
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