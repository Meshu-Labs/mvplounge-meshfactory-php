<?php

namespace MvpLounge\MeshFactory\Element\InlineTextSemantics;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/../../Abstract/FactoryElementHtmlAbstract.php';

class Span extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::SPAN
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::SPAN;
}
