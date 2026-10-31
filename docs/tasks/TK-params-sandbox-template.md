# TK Params Sandbox Template

Canonical scaffold for the **Params** sandbox flavor, referenced by every `*/Params/*-sandbox.php` script. The scaffold is derived from the existing scripts (for example `src/Sandbox/MeshFactory/TextContent/Params/Div-sandbox.php`). Overall test-type rules live in [TK-quality-check-playbook.md](TK-quality-check-playbook.md#sandbox-test-type-standard).

## Purpose

Prove that every attribute the class allows accepts a sample value through `configureFactory()` and that the result renders. Params scripts build the factory first and apply params afterwards; they do not pass scoped params through the constructor.

## Ownership And Editable Boundaries

| Area | Owner | Rule |
|---|---|---|
| `declare(strict_types=1)`, the two `require_once` lines, the banner, the `try/catch` frame, the `ERROR_*` output | Scaffold | Do not edit. |
| `$factory = new ...`, `$params = mfBuildScopedParams(...)`, `configureFactory($params)`, `mfAssertRenderableOutputs(...)` | Scaffold with one author edit | Change only the class name and the suffix string. |
| Extra assertions after `mfAssertRenderableOutputs()` | Author | Add exact fragment assertions here. |
| `PASS` lines | Author | Keep `PASS {class}` and `PASS assertions`. |

## Template

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Div Sandbox (Params) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-params-sandbox-template.md

try {

    #region Test Definition

    $factory = new \MvpLounge\MeshFactory\Element\TextContent\Div();

    // Build scoped params from the class's allowed and processable attributes.
    $params = mfBuildScopedParams($factory, 'div_textcontent');

    $factory->configureFactory($params);

    mfAssertRenderableOutputs($factory, $factory::class);

    echo 'PASS ' . $factory::class . PHP_EOL;
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

## How `mfBuildScopedParams()` Chooses Values

1. Base values for the global attributes (`id` becomes `el_id_{suffix}`, `class` becomes `el-class-{suffix}`, and so on).
2. Every attribute returned by `getAllowedFactoryElementAttributes()` plus every `__process_*` handler found by reflection, minus `configuration`, `element`, `ext`, `system`, `user`, `params`.
3. A deterministic sample per attribute (`href` becomes `https://example.test/{suffix}`, `rows` becomes `3`, media booleans become `true`, anything else becomes `{attribute}_{suffix}`).

Limit to keep in mind: `configureFactory()` dispatches only attributes that are in the class's attribute map, so samples for `data`, `content`, and `label` do not render (`EF-004`). Do not read a passing Params script as proof that those keys work.

## Rules

1. One class per script, named `{ClassName}-sandbox.php`, in `src/Sandbox/MeshFactory/{Domain}/Params/`.
2. Add exact fragment assertions for the attributes the class owns (`EF-051`).
3. Run the suite with `composer test` or `php src/Sandbox/MeshFactory/run-all.php`.
