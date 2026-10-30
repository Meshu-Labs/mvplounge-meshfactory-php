<?php

namespace MvpLounge\MeshFactory\Element\Scripting;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementScriptingAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementScriptingAbstract.php';

class Script extends FactoryElementScriptingAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::SCRIPT
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::SCRIPT;
}