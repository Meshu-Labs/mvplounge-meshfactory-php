<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== ObjectElement Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\EmbeddedContent\ObjectElement();
    $params = [
        'id' => 'el_id_objectelement_embeddedcontent',
        'class' => 'el-class-objectelement_embeddedcontent',
        'title' => 'Element title objectelement_embeddedcontent',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addSrc('/embedded/content/resource')
        ->addType('text/html')
        ->addName('embedded_content_name')
        ->addLoading('lazy')
        ->addDecoding('async')
        ->addFetchpriority('high')
        ->addContent('factory-content-objectelement_embeddedcontent', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\EmbeddedContent\ObjectElement::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\EmbeddedContent\ObjectElement::class . PHP_EOL;
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