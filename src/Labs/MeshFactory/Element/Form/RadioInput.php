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


require_once __DIR__ . '/../../Abstract/FactoryElementFieldInputAbstract.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementFieldType.php';
require_once __DIR__ . '/../../Enum/FactoryElementPrimativeType.php';



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
	protected ?object $FactoryElementFieldFieldset = NULL;

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

	public function build()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->buildElementRadios();
		$this->getElementFieldset()->buildElementClose();

	}

	public function buildElementRadios(): void
	{
		if (count($this->FactoryElementFieldCollection) > 0) {
			foreach ($this->FactoryElementFieldCollection as $_radio) {

				echo sprintf(
					'<div class="radio-wrarrer">%s%s</div>',
					$_radio->getElementFieldLabelOpen(),
					$_radio->addClass($this->FactoryElementUserClass)->addName($this->FactoryElementName)->getElementOpen()
				);
			}
		}
	}

	public function getFactoryModel(): array
	{

		return [
			'fields' => $this->getElementRadios(),
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
