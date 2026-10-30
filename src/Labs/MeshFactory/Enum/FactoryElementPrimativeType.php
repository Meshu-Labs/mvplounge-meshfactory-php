<?php

namespace MvpLounge\MeshFactory\Enum;


require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

enum FactoryElementPrimativeType: string
{
	case INT = 'int';
	case BOOL = 'bool';
	case STRING = 'string';
	case FLOAT = 'float';
}

