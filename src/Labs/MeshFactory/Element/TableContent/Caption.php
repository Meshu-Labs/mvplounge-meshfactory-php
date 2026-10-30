<?php

namespace MvpLounge\MeshFactory\Element\TableContent;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementHtmlAbstract.php';

class Caption extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::CAPTION
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::CAPTION;
}