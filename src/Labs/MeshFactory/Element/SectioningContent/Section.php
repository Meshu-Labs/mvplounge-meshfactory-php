<?php

namespace MvpLounge\MeshFactory\Element\SectioningContent;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/../../Abstract/FactoryElementHtmlAbstract.php';

class Section extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::SECTION
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::SECTION;
}
