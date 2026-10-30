<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Dd Sandbox (Params) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-params-sandbox-template.md


try {

    #region Test Definition


    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\TextContent\Dd();

    // Agent or Human:
    //
    // Build factory params
    //

    $params = mfBuildScopedParams($factory, 'dd_textcontent');

    // Agent or Human:
    //
    // Configure the factory with the scoped params
    //

    $factory->configureFactory($params);

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

    // Agent or Human:
    //
    // Emit error diagnostic messages - customize after generation
    //

    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);

    #endregion
}
