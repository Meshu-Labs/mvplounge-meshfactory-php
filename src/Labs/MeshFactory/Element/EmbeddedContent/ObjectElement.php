<?php

namespace MvpLounge\MeshFactory\Element\EmbeddedContent;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementEmbeddedContentAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementEmbeddedContentAbstract.php';

class ObjectElement extends FactoryElementEmbeddedContentAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::OBJECT
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::OBJECT;
}