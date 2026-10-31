<?php

namespace MvpLounge\MeshFactory\Element\Form;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementFieldsetAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementFieldsetAbstract.php';
require_once __DIR__ . '/FieldsetLabel.php';

/**
 * Concrete fieldset used by fields and by form sections.
 * It stores an optional FieldsetLabel and renders it when present.
 */
class Fieldset extends FactoryElementFieldsetAbstract
{
}
