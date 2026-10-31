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


class InputRadio extends FactoryElementFieldInputAbstract
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
				$this->FactoryElementFieldCollection[] = new InputRadio($_radios);
			}
		}
		return $this;
	}

	public function getElementFieldWrapperType(): string
	{
		return $this->hasRadioCollection() ? 'radio-group' : parent::getElementFieldWrapperType();
	}

	public function compileAsHtmlString(): ?string
	{
		if (!$this->hasRadioCollection()) {
			return parent::compileAsHtmlString();
		}

		return $this->getElementFieldWrapperOpen()
			. $this->getElementFieldLabelWrapper()
			. $this->renderRadioWrappedMarkup()
			. $this->getElementFieldWrapperClose();
	}

	public function build()
	{
		if (!$this->hasRadioCollection()) {
			parent::build();
			return;
		}

		echo $this->compileAsHtmlString() . "\n\t";
	}

	public function getElementFieldControl(): string
	{
		return $this->renderRadioMarkup();
	}

	public function buildElementFieldControl(): void
	{
		$this->buildElementRadios();
	}

	public function buildElementRadios(): void
	{
		echo $this->renderRadioMarkup();
	}

	protected function hasRadioCollection(): bool
	{
		return count($this->FactoryElementFieldCollection) > 0;
	}

	/** Raw radios: `div.radio-wrapper > label[for] > text + input#id` (explicit `for` plus implicit nesting). */
	protected function renderRadioMarkup(): string
	{
		if ($this->hasRadioCollection()) {
			$_radios = [];
			foreach ($this->FactoryElementFieldCollection as $_index => $_radio) {
				$this->prepareRadio($_radio, $_index);
				$_radios[] = sprintf(
					'<div class="radio-wrapper">%s%s%s</div>',
					$_radio->getElementFieldUnwrappedLabelOpen(),
					$_radio->getElementOpen(),
					$_radio->getElementFieldUnwrappedLabelClose()
				);
			}
			return implode('', $_radios);
		}

		return $this->getElementOpen();
	}

	/** Wrapped radios mirror `UI_RadioInputGroupField`: `label[for] > div.field-inner-wrapper > input#id` followed by the label block. */
	protected function renderRadioWrappedMarkup(): string
	{
		$_radios = [];
		foreach ($this->FactoryElementFieldCollection as $_index => $_radio) {
			$this->prepareRadio($_radio, $_index);
			$_radios[] = sprintf(
				'<label%s>%s%s%s<div class="clear"></div></label>',
				$_radio->getElementFieldLabelAttributes(),
				$_radio->getElementFieldInnerWrapperOpen(),
				$_radio->getElementOpen() . $_radio->getElementFieldInnerWrapperClose(),
				$_radio->getElementFieldLabelWrapper()
			);
		}
		return implode('', $_radios);
	}

	/** Applies the group class and name, and gives each radio an id so its label can use an explicit `for`. */
	protected function prepareRadio(InputRadio $radio, $index): InputRadio
	{
		$radio->addClass($this->FactoryElementUserClass)->addName($this->FactoryElementName);

		if ($radio->getFactoryId() === NULL) {
			$_base = $this->getFactoryId() ?? $this->FactoryElementName;
			if ($_base !== NULL && $_base !== '') {
				$radio->addId(preg_replace('/[^A-Za-z0-9_-]/', '_', $_base . '_' . $index));
			}
		}

		return $radio;
	}

	protected function getElementFieldLabelAttributes(): string
	{
		$_id = $this->getFactoryId();
		return $_id ? sprintf(' for="%s"', htmlspecialchars($_id, ENT_QUOTES)) : '';
	}

	public function getFactoryModel(): array
	{

		return [
			'name' => $this->getFactoryName(),
			'field' => $this->getElementRadios(),
			'labelOpen' => $this->getElementFieldLabelOpen(),
			'labelClose' => $this->getElementFieldLabelClose(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

	public function getElementRadios(): array
	{

		$_radios = [];

		if ($this->hasRadioCollection()) {
			foreach ($this->FactoryElementFieldCollection as $_radio_index => $_radio) {
				$this->prepareRadio($_radio, $_radio_index);
				$_radios[$_radio_index] = [
					'label' => $_radio->getElementFieldLabelWrapper(),
					'labelAttributes' => $_radio->getElementFieldLabelAttributes(),
					'field' => $_radio->getElementOpen()
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
