<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../_shared/factory-element-sandbox-shared.php';

echo '=== Nobr Sandbox (Params) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-params-sandbox-template.md

try {

    #region Test Definition

    // Agent or Human:
    // 
    // Manage logic to instantiate the factory
    //

    $factory = new \MvpLounge\MeshFactory\Element\ObsoleteAndDeprecated\Nobr();

    // Agent or Human : 
    // 
    // Build factory params
    // 
    // Method 1 -  $params = [EnumFactoryElementAttribute::ATTRIBUTE_NAME => 'value', ...] or 
    // Method 2 - mfBuildScopedParams($factory, 'scoped_name') to build params from a JSON file in the /sandbox/_shared/params/ folder
    //

    $params = mfBuildScopedParams($factory, 'nobr_obsoleteanddeprecated');

    // Agent or Human:
    //     
    // Configure the factory with the scoped params
    //

    $factory->configureFactory($params);

    // Agent or Human:
    // 
    // Method 1 - Assert renderable outputs
    // Method 2 - echo $factory->compileAsString(), $factory->compileAsArray(), $factory->compileAsJson() and $factory->compileAsHtml()
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

