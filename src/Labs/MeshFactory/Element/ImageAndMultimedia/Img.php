<?php

namespace MvpLounge\MeshFactory\Element\ImageAndMultimedia;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementImageAndMultimediaAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/../../Abstract/FactoryElementImageAndMultimediaAbstract.php';

class Img extends FactoryElementImageAndMultimediaAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::IMG
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::IMG;
}
