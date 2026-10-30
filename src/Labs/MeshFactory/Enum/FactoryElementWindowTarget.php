<?php

namespace MvpLounge\MeshFactory\Enum;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

enum FactoryElementWindowTarget: string
{
    case SELF = '_self';
    case BLANK = '_blank';
    case PARENT = '_parent';
    case TOP = '_top';
}
