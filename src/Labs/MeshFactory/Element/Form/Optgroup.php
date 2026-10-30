<?php

namespace MvpLounge\MeshFactory\Element\Form;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementFormElementsAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementFormElementsAbstract.php';

class Optgroup extends FactoryElementFormElementsAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::OPTGROUP
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::OPTGROUP;
}