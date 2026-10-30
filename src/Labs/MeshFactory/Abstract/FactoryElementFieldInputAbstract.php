<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/FactoryElementFieldAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';

/**
 * Input-control specialization layer.
 *
 * This extra field abstraction is intentionally kept to support
 * deeper field-family composition contracts.
 */
abstract class FactoryElementFieldInputAbstract extends FactoryElementFieldAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::INPUT
    ];

    protected array $AllowedFactoryElementAttributes = [
        FactoryElementAttribute::NAME,
        FactoryElementAttribute::PLACEHOLDER,
        FactoryElementAttribute::TYPE,
        FactoryElementAttribute::VALUE,
        FactoryElementAttribute::ACCESS
    ];

    public function getFactoryModel(): array
    {
        return [
            'name' => $this->getFactoryName(),
            'field' => $this->getElementOpen()
        ];
    }

    public function build()
    {
        $this->buildElementOpen();
    }
}
