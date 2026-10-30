<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Abbr Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory


    $factory = new \MvpLounge\MeshFactory\Element\InlineTextSemantics\Abbr();

    // Agent or Human:
    //
    // Build factory params
    //

    $params = [
        'id' => 'el_id_abbr_inlinetextsemantics',
        'class' => 'el-class-abbr_inlinetextsemantics',
        'title' => 'Element title abbr_inlinetextsemantics',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    // Agent or Human:
    //
    // Perform fluent factory scripting
    //

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addContent('factory-content-abbr_inlinetextsemantics', true);

    // Agent or Human:
    //
    // Assert renderable outputs
    //

    mfAssertRenderableOutputs($factory, $factory::class);

    // Emit success diagnostic messages - customize after generation

    echo 'PASS ' . $factory::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;

    #endregion

} catch (Throwable $e) {

    #region Error Handling

    // Emit error diagnostic messages - customize after generation

    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;

    exit(1);

    #endregion
}