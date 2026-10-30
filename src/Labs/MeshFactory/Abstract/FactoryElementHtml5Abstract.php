<?php

namespace MvpLounge\MeshFactory\Abstract;

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;

require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';
require_once __DIR__ . '/../Element/Field/FormButton.php';
require_once __DIR__ . '/../Element/Field/HiddenInput.php';
require_once __DIR__ . '/FactoryElementFieldAbstract.php';

abstract class FactoryElementHtml5Abstract extends FactoryElementAbstract
{

	protected array $AllowedFactoryElements = [
		FactoryElement::DIV,
		FactoryElement::SPAN,
		FactoryElement::LABEL,
		FactoryElement::ASIDE,
		FactoryElement::CONTENT,
		FactoryElement::HEADER,
		FactoryElement::FIGURE,
		FactoryElement::MAIN,
		FactoryElement::SECTION,
		FactoryElement::ARTICLE,
		FactoryElement::FOOTER,
		FactoryElement::NAV
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::FOR
	];
	protected ?FactoryElement $FactoryElement = FactoryElement::DIV;
	protected ?string $FactoryElementSystemClass = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	public function addElementClose(): void
	{
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementClose = $this->getElementFactoryClose($this->FactoryElement->value);
		}
	}

	public function addElementOpen($params = []): void
	{
		if (count($params) > 0) {
			$this->__process_params($params);
		}
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementOpen = $this->getElementFactoryOpen($this->FactoryElement->value, $this->getFactoryAttributePropertyCollection());
		}
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		return $this->getDefaultFactoryAttributePropertyCollection();
	}

	public function string(): ?string
	{
		return $this->getElementOpen() . $this->getElementContent() . $this->getElementClose();
	}

}
