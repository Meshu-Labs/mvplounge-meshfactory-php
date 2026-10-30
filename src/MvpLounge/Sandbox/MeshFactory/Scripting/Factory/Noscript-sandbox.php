<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Noscript Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\Scripting\Noscript();
    $params = [
        'id' => 'el_id_noscript_scripting',
        'class' => 'el-class-noscript_scripting',
        'title' => 'Element title noscript_scripting',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addSrc('/assets/script.js')
        ->addType('module')
        ->addIntegrity('sha256-test')
        ->addCrossorigin('anonymous')
        ->addReferrerpolicy('origin')
        ->addContent('factory-content-noscript_scripting', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\Scripting\Noscript::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\Scripting\Noscript::class . PHP_EOL;
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