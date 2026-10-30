<?php

namespace MvpLounge\MeshFactory\Element\TextContent;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementHtmlAbstract.php';

class Ul extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::UL
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::UL;
}