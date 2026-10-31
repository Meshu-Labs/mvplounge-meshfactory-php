# TK Factory Sandbox Template

Canonical scaffold for the **Factory** sandbox flavor, referenced by every `*/Factory/*-sandbox.php` script. The scaffold is derived from the existing scripts (for example `src/Sandbox/MeshFactory/TextContent/Factory/Div-sandbox.php`). Overall test-type rules live in [TK-quality-check-playbook.md](TK-quality-check-playbook.md#sandbox-test-type-standard).

## Purpose

Prove that the fluent mutators of one concrete class chain and render. The script calls explicit `add*()` methods by name; it does not generate method names from attribute strings.

## Ownership And Editable Boundaries

| Area | Owner | Rule |
|---|---|---|
| `declare(strict_types=1)`, the two `require_once` lines, the `echo '=== Name Sandbox (Factory) ==='` banner, the `try { ... } catch` frame, and the `ERROR_*` output | Scaffold | Do not edit. |
| Everything between `#region Test Definition` and `#endregion` | Author | Instantiate the class, call the fluent chain, assert. |
| The `PASS` lines | Author | Keep the two lines `PASS {class}` and `PASS assertions`; `run-all.php` and the quality gate look for `PASS assertions`. |

## Template

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Div Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

try {

    #region Test Definition

    $factory = new \MvpLounge\MeshFactory\Element\TextContent\Div();

    $factory->addId('el_id_div_textcontent')
        ->addClass('el-class-div_textcontent')
        ->addTitle('Element title div_textcontent')
        ->addStyle('display:block')
        ->addLang('en')
        ->addContent('factory-content-div_textcontent', true);

    mfAssertRenderableOutputs($factory, \MvpLounge\MeshFactory\Element\TextContent\Div::class);
    echo 'PASS ' . \MvpLounge\MeshFactory\Element\TextContent\Div::class . PHP_EOL;
    echo 'PASS assertions' . PHP_EOL;

    #endregion

} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}
```

## Rules

1. One class per script, named `{ClassName}-sandbox.php`, in `src/Sandbox/MeshFactory/{Domain}/Factory/`.
2. Use only mutators the class really has. For elements with family attributes, chain them too (for example `->addHref('/x')` on `Anchor`).
3. Replace `mfAssertRenderableOutputs()` with exact assertions as classes gain golden expectations (`EF-051`).
4. Run the suite with `composer test` or `php src/Sandbox/MeshFactory/run-all.php`.
