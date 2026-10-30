<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;

echo '=== Anchor Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\InlineTextSemantics\Anchor();
    $params = [
        'id' => 'el_id_anchor_inlinetextsemantics',
        'class' => 'el-class-anchor_inlinetextsemantics',
        'title' => 'Element title anchor_inlinetextsemantics',
        'style' => 'display:block',
        'lang' => 'en'
    ];

    $factory->addId((string) $params['id'])
        ->addClass((string) $params['class'])
        ->addTitle((string) $params['title'])
        ->addStyle((string) $params['style'])
        ->addLang((string) $params['lang'])
        ->addHref('/inline/anchor')
        ->addTarget(FactoryElementWindowTarget::BLANK->value)
        ->addRel('noopener')
        ->addHreflang('en')
        ->addMedia('screen')
        ->addPing('/ping')
        ->addReferrerpolicy('origin')
        ->addType('text/html')
        ->addContent('factory-content-anchor_inlinetextsemantics', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\InlineTextSemantics\Anchor::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\InlineTextSemantics\Anchor::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;

    #endregion

    exit(1);
}