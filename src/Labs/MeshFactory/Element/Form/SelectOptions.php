<?php

namespace MvpLounge\MeshFactory\Element\Field;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementPrimativeType;
use MvpLounge\MeshFactory\Abstract\FactoryElementFieldAbstract;


require_once __DIR__ . '/../../Abstract/FactoryElementFieldAbstract.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementPrimativeType.php';




class SelectOptions extends FactoryElementFieldAbstract
{
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::VALUE,
		FactoryElementAttribute::SELECTED
	];

	protected ?FactoryElement $FactoryElement = FactoryElement::OPTION;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::INT;
	protected ?object $FactoryElementFieldFieldset = NULL;
	protected ?bool $FactoryElementFieldSelected = FALSE;
	protected ?string $FactoryElementSystemClass = 'field_ui';

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

	public function build()
	{
		$this->buildElementOpen();
		$this->buildElementContent();
		$this->buildElementClose();

	}

	public function getFactoryModel(): array
	{

		return [
			'open' => $this->getElementOpen(),
			'content' => $this->getElementContent(),
			'close' => $this->getElementClose()
		];
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'value' => $this->getFactoryElementSelectValue($_allowed),
				'selected' => $this->getFactoryElementSelectSelected($_allowed)
			]
		);
	}

	protected function getFactoryElementSelectValue(array $allowed)
	{
		return in_array(FactoryElementAttribute::VALUE->value, $allowed, TRUE) ? $this->getElementFieldValue() : NULL;
	}

	protected function getFactoryElementSelectSelected(array $allowed): ?bool
	{
		return in_array(FactoryElementAttribute::SELECTED->value, $allowed, TRUE) ? $this->getElementFieldSelected() : NULL;
	}

	public function getElementFieldSelected(): ?bool
	{
		return $this->FactoryElementFieldSelected;
	}

	protected function __process_selected($params): void
	{
		if (isset($params['selected'])) {
			$this->addSelected($params['selected']);
		}
	}

	public function compileAsHtmlString(): ?string
	{
		return $this->getElementOpen()
			. $this->getElementContent()
			. $this->getElementClose();
	}

	public function string(): ?string
	{
		return $this->compileAsHtmlString();
	}

	public function not_selected(): static
	{
		$this->addSelected(FALSE);
		return $this;
	}

	public function selected(): static
	{
		$this->addSelected(TRUE);
		return $this;
	}

	public function addSelected($selected): static
	{
		$this->FactoryElementFieldSelected = (bool) $selected;
		return $this;
	}

}

