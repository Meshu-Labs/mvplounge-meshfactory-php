<?php

namespace MvpLounge\MeshFactory\Element\MetaData;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementMetaDataAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementMetaDataAbstract.php';

class Style extends FactoryElementMetaDataAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::STYLE
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::STYLE;
}