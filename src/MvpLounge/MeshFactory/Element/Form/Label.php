<?php

namespace MvpLounge\MeshFactory\Element\Form;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementFormElementsAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/../../Abstract/FactoryElementFormElementsAbstract.php';

class Label extends FactoryElementFormElementsAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::LABEL
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::LABEL;
}
