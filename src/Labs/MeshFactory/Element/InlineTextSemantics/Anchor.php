<?php

namespace MvpLounge\MeshFactory\Element\InlineTextSemantics;

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementLinkAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementLinkAbstract.php';

/**
 * Canonical source-of-truth class for <a> in the InlineTextSemantics domain.
 */
class Anchor extends FactoryElementLinkAbstract
{
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
}
