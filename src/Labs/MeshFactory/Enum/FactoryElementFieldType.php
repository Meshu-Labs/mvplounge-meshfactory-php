<?php

namespace MvpLounge\MeshFactory\Enum;


require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

enum FactoryElementFieldType: string
{
	case TEXT = 'text';
	case EMAIL = 'email';
	case PASSWORD = 'password';
	case HIDDEN = 'hidden';
	case RADIO = 'radio';
	case BUTTON = 'button';
	case SUBMIT = 'submit';
}
