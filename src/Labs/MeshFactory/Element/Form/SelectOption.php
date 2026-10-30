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


require_once __DIR__ . '/SelectOptions.php';
require_once __DIR__ . '/../../Abstract/FactoryElementFieldAbstract.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementPrimativeType.php';




class SelectOption extends FactoryElementFieldAbstract
{
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::NAME,
		FactoryElementAttribute::VALUE,
		FactoryElementAttribute::ACCESS
	];

	protected ?FactoryElement $FactoryElement = FactoryElement::SELECT;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::INT;
	protected ?array $FactoryElementSelectFieldOptions = [];
	protected bool $FactoryElementFieldSelected = FALSE;
	protected ?object $FactoryElementFieldFieldset = NULL;
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
		$this->getElementFieldset()->buildElementOpen();
		$this->buildElementLabelOpen();
		$this->buildElementOpen();
		$this->buildElementOptions();
		$this->buildElementClose();
		$this->buildElementLabelClose();
		$this->getElementFieldset()->buildElementClose();

	}

	public function buildElementOptions()
	{
		if (count($this->FactoryElementSelectFieldOptions) > 0) {
			foreach ($this->FactoryElementSelectFieldOptions as $_option_factory) {
				if (($_option_factory instanceof SelectOptions)) {
					$_option_factory->build();
				}
			}
		}
	}

	public function getFactoryModel(): array
	{

		return [
			'open' => $this->getElementOpen(),
			'options' => $this->getElementFieldOptions(),
			'close' => $this->getElementClose(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

	public function getElementFieldOptions($string = FALSE)
	{

		$_options = [];
		$_options_string = '';

		if ($this->hasOptions()) {
			foreach ($this->FactoryElementSelectFieldOptions as $_option_factory_value => $_option_factory) {
				if (($_option_factory instanceof SelectOptions)) {
					if ($this->getElementFieldValue() === $_option_factory_value) {
						$_option_factory->selected();
					} else {
						$_option_factory->not_selected();
					}
				}
				if ($string) {
					$_options_string .= $_option_factory->compileAsHtmlString();
				} else {
					$_options[$_option_factory_value] = $_option_factory->compileAsArray();
				}
			}
		}

		return $string ? $_options_string : $_options;
	}

	public function hasOptions()
	{
		return count($this->FactoryElementSelectFieldOptions) > 0;
	}

	public function compileAsHtmlString(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. $this->getElementFieldLabelOpen()
			. $this->getElementOpen()
			. $this->getElementFieldOptions(TRUE)
			. $this->getElementClose()
			. $this->getElementFieldLabelClose()
			. $this->getElementFieldset()->getElementClose();
	}

	public function string(): ?string
	{
		return $this->compileAsHtmlString();
	}

	public function getElementFieldSelected(): bool
	{
		return $this->FactoryElementFieldSelected;
	}

	public function addOptions($options): FactoryElementFieldAbstract
	{

		if (is_array($options)) {
			foreach ($options as $_option_index => $_option) {

				if (!is_string($_option) && (!is_countable($_option) || !is_array($_option))) {
					continue;
				}

				if (!isset($this->FactoryElementSelectFieldOptions[$_option_index])) {

					if (is_string($_option)) {
						$this->FactoryElementSelectFieldOptions[$_option_index] = new SelectOptions([
							'value' => $_option_index,
							'content' => $_option
						]);
					}

					if (is_countable($_option) && is_array($_option)) {

						$this->FactoryElementSelectFieldOptions[$_option_index] = new SelectOptions([
							'vType' => $_option['vType'] ?? NULL,
							'value' => $_option['value'] ?? $_option_index,
							'content' => $_option['label'] ?? NULL,
							'id' => $_option['id'] ?? NULL,
							'name' => $_option['name'] ?? NULL,
							'data' => $_option['data'] ?? NULL,
							'system' => $_option['system'] ?? NULL,
							'user' => $_option['user'] ?? NULL

						]);
					}
				}
			}
		}

		return $this;
	}

}
