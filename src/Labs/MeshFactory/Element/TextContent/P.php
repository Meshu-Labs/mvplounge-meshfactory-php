<?php

namespace MvpLounge\MeshFactory\Element\TextContent;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/../../Abstract/FactoryElementHtmlAbstract.php';

class P extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::P
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::P;
}
