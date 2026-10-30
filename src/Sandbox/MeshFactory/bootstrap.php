<?php

declare(strict_types=1);

/**
 * Resolve Composer autoload for both local repo runs and dependency installs.
 */
$searchDir = __DIR__;
$autoloader = null;

for ($depth = 0; $depth < 12; $depth++) {
    $candidates = [
        $searchDir . '/vendor/autoload.php',
        $searchDir . '/autoload.php'
    ];

    foreach ($candidates as $candidate) {
        if (file_exists($candidate)) {
            $autoloader = $candidate;
            break 2;
        }
    }

    $parent = dirname($searchDir);
    if ($parent === $searchDir) {
        break;
    }

    $searchDir = $parent;
}

if ($autoloader === null) {
    throw new RuntimeException('Composer autoload not found from bootstrap path: ' . __DIR__);
}

require_once $autoloader;


