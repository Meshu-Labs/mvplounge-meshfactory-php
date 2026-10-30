<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementAbstract;

require_once __DIR__ . '/FactoryElementAbstract.php';

abstract class FactoryElementHtmlAbstract extends FactoryElementAbstract
{
    public function getFactoryAttributePropertyCollection(): array
    {
        return $this->getDefaultFactoryAttributePropertyCollection();
    }
}