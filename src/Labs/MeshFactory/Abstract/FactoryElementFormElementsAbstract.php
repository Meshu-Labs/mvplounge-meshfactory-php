<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/FactoryElementHtmlAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';

abstract class FactoryElementFormElementsAbstract extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::BUTTON,
        FactoryElement::DATALIST,
        FactoryElement::LABEL,
        FactoryElement::LEGEND,
        FactoryElement::METER,
        FactoryElement::OPTGROUP,
        FactoryElement::OUTPUT,
        FactoryElement::PROGRESS
    ];

    protected array $AllowedFactoryElementAttributes = [
        FactoryElementAttribute::FOR
    ];

    protected ?string $FactoryElementFormFor = NULL;

    protected function __process_for($params): void
    {
        if (array_key_exists('for', $params)) {
            $this->addFor($params['for']);
        }
    }

    public function addFor($for): static
    {
        if (is_null($for)) {
            $this->FactoryElementFormFor = NULL;
            return $this;
        }

        $this->FactoryElementFormFor = (string) $for;
        return $this;
    }

    public function getFactoryElementFormFor(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::FOR ->value, $allowed, TRUE) ? $this->FactoryElementFormFor : NULL;
    }

    public function getFactoryAttributePropertyCollection(): array
    {
        $_allowed = $this->getAllowedFactoryElementAttributes();

        return array_merge(
            $this->getDefaultFactoryAttributePropertyCollection(),
            [
                'for' => $this->getFactoryElementFormFor($_allowed)
            ]
        );
    }
}
