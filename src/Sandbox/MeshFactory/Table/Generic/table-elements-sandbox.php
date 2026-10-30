<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Table Sandbox (Generic) ===' . PHP_EOL;

try {
    $factories = [
        'DataTableBody' => new \MvpLounge\MeshFactory\Element\Table\DataTableBody(),
        'TableBody' => new \MvpLounge\MeshFactory\Element\Table\TableBody(),
        'TableCell' => new \MvpLounge\MeshFactory\Element\Table\TableCell(),
        'TableFooter' => new \MvpLounge\MeshFactory\Element\Table\TableFooter(),
        'TableHead' => new \MvpLounge\MeshFactory\Element\Table\TableHead(),
        'TableHeader' => new \MvpLounge\MeshFactory\Element\Table\TableHeader(),
        'TableRow' => new \MvpLounge\MeshFactory\Element\Table\TableRow(),
        'TableRowBody' => new \MvpLounge\MeshFactory\Element\Table\TableRowBody()
    ];

    foreach ($factories as $label => $factory) {
        if ($factory->addClass('generic-' . strtolower($label)) !== $factory) {
            throw new RuntimeException($label . ' addClass() must remain fluent.');
        }
        $html = $factory->compileAsHtmlString();
        echo '-- ' . $label . ' compileAsHtmlString() --' . PHP_EOL;
        var_dump($html);
        if (!is_string($html)) {
            throw new RuntimeException($label . ' compileAsHtmlString() must return a string.');
        }
    }

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}