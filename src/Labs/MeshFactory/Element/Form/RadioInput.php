<?php

namespace MvpLounge\MeshFactory\Element\Field;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementFieldType;
use MvpLounge\MeshFactory\Enum\FactoryElementPrimativeType;
use MvpLounge\MeshFactory\Abstract\FactoryElementFieldInputAbstract;
use MvpLounge\MeshFactory\Abstract\FactoryElementFieldsetAbstract;


require_once __DIR__ . '/../../Abstract/FactoryElementFieldInputAbstract.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementFieldType.php';
require_once __DIR__ . '/../../Enum/FactoryElementPrimativeType.php';


// change file name to InputRadio. Change class name to InputRadio. Update all references.
class RadioInput extends FactoryElementFieldInputAbstract
{
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::NAME,
		FactoryElementAttribute::PLACEHOLDER,
		FactoryElementAttribute::TYPE,
		FactoryElementAttribute::VALUE,
		FactoryElementAttribute::CHECKED,
		FactoryElementAttribute::ACCESS
	];
	protected bool $FactoryElementFieldChecked = FALSE;
	protected ?array $FactoryElementFieldCollection = [];
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::RADIO;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::STRING;
	protected ?FactoryElementFieldsetAbstract $FactoryElementFieldFieldset = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_checked($params)
	{
		if (isset($params['checked']) && is_bool($params['checked'])) {
			$this->addChecked($params['checked']);
		}
	}

	public function addChecked($checked): static
	{
		$this->FactoryElementFieldChecked = (bool) $checked;
		return $this;
	}

	public function addCheckedElements($params): static
	{
		if (is_array($params)) {
			foreach ($params as $_radios) {
				$this->FactoryElementFieldCollection[] = new RadioInput($_radios);
			}
		}
		return $this;
	}

	public function compileAsHtmlStringWithFieldset(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. $this->getElementFieldLabelOpen()
			. $this->renderRadioMarkup()
			. $this->getElementFieldLabelClose()
			. $this->getElementFieldset()->getElementClose();
	}

	public function compileAsHtmlString(): ?string
	{
		return $this->getElementFieldLabelOpen()
			. $this->renderRadioMarkup()
			. $this->getElementFieldLabelClose();
	}

	public function build()
	{
		$this->buildElementLabelOpen();
		$this->buildElementRadios();
		$this->buildElementLabelClose();
	}

	public function buildWithFieldset()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->buildElementLabelOpen();
		$this->buildElementRadios();
		$this->buildElementLabelClose();
		$this->getElementFieldset()->buildElementClose();
	}

	public function buildElementRadios(): void
	{
		echo $this->renderRadioMarkup();
	}

	protected function renderRadioMarkup(): string
	{
		if (count($this->FactoryElementFieldCollection) > 0) {
			$_radios = [];
			foreach ($this->FactoryElementFieldCollection as $_radio) {
				$_radios[] = sprintf(
					'<div class="radio-wrapper">%s%s</div>',
					$_radio->getElementFieldLabelOpen(),
					$_radio->addClass($this->FactoryElementUserClass)->addName($this->FactoryElementName)->getElementOpen()
				);
			}
			return implode('', $_radios);
		}

		return $this->getElementOpen();
	}

	public function getFactoryModel(): array
	{

		return [
			'name' => $this->getFactoryName(),
			'field' => $this->getElementRadios(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

	public function getElementRadios(): array
	{

		$_radios = [];

		if (count($this->FactoryElementFieldCollection) > 0) {
			foreach ($this->FactoryElementFieldCollection as $_radio_index => $_radio) {
				$_radios[$_radio_index] = [
					'label' => $_radio->getElementFieldLabelOpen(),
					'field' => $_radio->addClass($this->FactoryElementUserClass)->addName($this->FactoryElementName)->getElementOpen()
				];
			}
		}

		return $_radios;
	}

	public function getElementFieldChecked(): bool
	{
		return $this->FactoryElementFieldChecked;
	}

}
