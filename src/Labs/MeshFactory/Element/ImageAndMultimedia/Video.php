<?php

namespace MvpLounge\MeshFactory\Element\ImageAndMultimedia;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementImageAndMultimediaAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementImageAndMultimediaAbstract.php';

class Video extends FactoryElementImageAndMultimediaAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::VIDEO
    ];

    protected ?FactoryElement $FactoryElement = FactoryElement::VIDEO;
}