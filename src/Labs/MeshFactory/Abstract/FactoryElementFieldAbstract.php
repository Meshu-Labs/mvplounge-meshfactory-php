<?php

namespace MvpLounge\MeshFactory\Abstract;



require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementFieldType;
use MvpLounge\MeshFactory\Enum\FactoryElementPrimativeType;
use MvpLounge\MeshFactory\Element\Form\Fieldset;


require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Element/Form/Fieldset.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElementFieldType.php';
require_once __DIR__ . '/../Enum/FactoryElementPrimativeType.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';

/**
 * Form control support spanning input, select, option, textarea, and fieldset families.
 *
 * MDN element references:
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/textarea
 */
abstract class FactoryElementFieldAbstract extends FactoryElementAbstract
{

	protected array $AllowedFactoryElements = [
		FactoryElement::FIELDSET,
		FactoryElement::INPUT,
		FactoryElement::SELECT,
		FactoryElement::OPTION,
		FactoryElement::TEXTAREA
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::NAME,
		FactoryElementAttribute::PLACEHOLDER,
		FactoryElementAttribute::TYPE,
		FactoryElementAttribute::VALUE,
		FactoryElementAttribute::SELECTED,
		FactoryElementAttribute::CHECKED,
		FactoryElementAttribute::ACCESS
	];

	protected ?FactoryElement $FactoryElement = NULL;
	protected ?FactoryElementFieldType $FactoryElementFieldType = NULL;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::STRING;
	/** Internal enabled or disabled state rendered from the legacy access flag. */
	protected ?bool $FactoryElementFieldAccess = NULL;
	protected ?string $FactoryElementFieldAct = NULL;
	protected ?bool $FactoryElementFieldBooleanValue = NULL;
	protected ?float $FactoryElementFieldFloatValue = NULL;
	protected ?int $FactoryElementFieldIntValue = NULL;
	protected ?string $FactoryElementFieldLabel = NULL;
	protected ?string $FactoryElementFieldTooltip = NULL;
	protected ?int $FactoryElementFieldLength = NULL;
	protected ?string $FactoryElementFieldStringValue = NULL;
	protected ?string $FactoryElementSystemClass = 'field_ui';
	protected ?FactoryElementFieldsetAbstract $FactoryElementFieldFieldset = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_params($params): void
	{
		parent::__process_params($params);
		if (is_array($params)) {
			$this->__process_label($params);
			$this->__process_tooltip($params);
		}
	}

	protected function __process_access($params): void
	{

		if (isset($params['access']) && is_bool($params['access'])) {
			$this->addAccess($params['access']);
		}
	}

	public function addAccess($access): static
	{
		$this->FactoryElementFieldAccess = $access;
		return $this;
	}

	protected function __process_act($params): void
	{

		if (isset($params['act']) && is_string($params['act'])) {
			$this->addAct($params['act']);
		}
	}

	public function addAct($act): static
	{
		$this->FactoryElementFieldAct = $act;
		return $this;
	}

	protected function __process_fieldset($params): void
	{

		if (isset($params['fieldset']) && is_array($params['fieldset'])) {
			$this->addFieldset($params['fieldset']);
		}
	}

	public function addFieldset($params): static
	{
		$this->FactoryElementFieldFieldset = (new Fieldset())->configureFactory($params);
		return $this;
	}

	protected function __process_label($params): void
	{

		if (!empty($params['label'])) {
			$this->addLabel($params['label']);
		}
	}

	public function addLabel($label): static
	{
		$this->FactoryElementFieldLabel = $label;
		return $this;
	}

	protected function __process_tooltip($params): void
	{

		if (!empty($params['tooltip'])) {
			$this->addTooltip($params['tooltip']);
		}
	}

	public function addTooltip($tooltip): static
	{
		$this->FactoryElementFieldTooltip = $tooltip;
		return $this;
	}


	protected function __process_length($params): void
	{

		if (!empty($params['length'])) {
			$this->addlength($params['length']);
		}
	}

	public function addLength($length): static
	{
		$this->FactoryElementFieldLength = $length;
		return $this;
	}

	protected function __process_type($params): void
	{
		if (!empty($params['type'])) {
			$this->addType($params['type']);
		}
	}

	public function addType($type): static
	{
		if ($type instanceof FactoryElementFieldType) {
			$this->FactoryElementFieldType = $type;
			return $this;
		}

		if (is_string($type)) {
			$_type = FactoryElementFieldType::tryFrom(strtolower($type));
			if ($_type instanceof FactoryElementFieldType) {
				$this->FactoryElementFieldType = $_type;
			}
		}

		return $this;
	}

	protected function __process_value($params): void
	{

		if (!empty($params['vtype'])) {
			$this->addValueType($params['vtype']);
		}

		if (isset($params['value'])) {
			$this->addValue($params['value']);
		}
	}

	public function addValueType($valueType): static
	{
		if ($valueType instanceof FactoryElementPrimativeType) {
			$this->FactoryElementFieldValueType = $valueType;
			return $this;
		}

		if (is_string($valueType)) {
			$_vtype = FactoryElementPrimativeType::tryFrom(strtolower($valueType));
			if ($_vtype instanceof FactoryElementPrimativeType) {
				$this->FactoryElementFieldValueType = $_vtype;
			}
		}

		return $this;
	}

	public function addValue($value): static
	{
		$_value_type = $this->FactoryElementFieldValueType?->value ?? FactoryElementPrimativeType::STRING->value;
		$_field_prop = sprintf('FactoryElementField%sValue', ucfirst($_value_type));

		if (property_exists($this, $_field_prop)) {
			$_value = NULL;
			switch ($_value_type) {
				case 'int':
					if (!is_bool($value)) {
						$_value = intval($value);
					}
					break;
				case 'string':
					$_value = strval($value);
					break;
				case 'float':
					if (!is_bool($value)) {
						$_value = floatval($value);
					}
					break;
				case 'bool':
					$_value = boolval($value);
					break;
			}
			$this->{$_field_prop} = $_value;
		} else {
			$this->FactoryElementFieldStringValue = (string) $value;
		}

		return $this;
	}

	public function addElementClose(): void
	{
		return;
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

	public function getElementFactoryOpen($element, $params = [], $render = TRUE): string
	{

		$_e = $this->getElementFactory($element);
		if (!$_e) {
			return '';
		}

		$_model = $this->getElementFactoryDefaultPropertiesFromParams($params);

		foreach ($this->FactoryElementAttributeMap as $_attribute => $_attribute_value) {
			if (array_key_exists($_attribute_value, $params)) {
				$_model[$_attribute_value] = $this->getElementFactoryProperty($_attribute_value, $params[$_attribute_value]);
			}
		}

		switch ($_e) {
			case 'textarea':
				$_model['rows'] = $this->getElementFactoryProperty('rows', $params['rows'] ?? NULL);
				$_model['cols'] = $this->getElementFactoryProperty('cols', $params['cols'] ?? NULL);
			case 'input':
				$_model['placeholder'] = $this->getElementFactoryProperty('placeholder', $params['placeholder'] ?? NULL);
				$_model['type'] = $this->getElementFactoryProperty('type', $params['type'] ?? NULL);
				$_model['checked'] = $this->getElementFactoryProperty('checked', $params['checked'] ?? NULL);
				break;
			case 'select':
				$_model['options'] = $this->getElementFactoryProperty('options', $params['options'] ?? NULL);
				break;
			case 'option':
				$_model['selected'] = $this->getElementFactoryProperty('selected', $params['selected'] ?? NULL);
				break;
		}

		return $this->getElementFactoryOpenPropertiesString($_e, $_model);
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'access' => $this->getFactoryElementFieldAccess($_allowed),
				'value' => $this->getFactoryElementFieldValue($_allowed),
				'selected' => $this->getFactoryElementFieldSelected($_allowed),
				'type' => $this->getFactoryElementFieldType($_allowed),
				'placeholder' => $this->getFactoryElementFieldPlaceholder($_allowed),
				'checked' => $this->getFactoryElementFieldChecked($_allowed)
			]
		);
	}

	public function getFactoryModel(): array
	{
		return [
			'name' => $this->getFactoryName(),
			'field' => $this->compileAsArray(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

	public function getFactoryElementFieldAccess(array $allowed): ?bool
	{
		return in_array(FactoryElementAttribute::ACCESS->value, $allowed, TRUE) ? $this->FactoryElementFieldAccess : NULL;
	}

	public function getFactoryElementFieldValue(array $allowed)
	{
		return in_array(FactoryElementAttribute::VALUE->value, $allowed, TRUE) ? $this->getElementFieldValue() : NULL;
	}

	public function getFactoryElementFieldSelected(array $allowed)
	{
		return in_array(FactoryElementAttribute::SELECTED->value, $allowed, TRUE) && method_exists($this, 'getElementFieldSelected') ? $this->getElementFieldSelected() : NULL;
	}

	public function getFactoryElementFieldType(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::TYPE->value, $allowed, TRUE) ? $this->getElementFieldType() : NULL;
	}

	public function getFactoryElementFieldPlaceholder(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::PLACEHOLDER->value, $allowed, TRUE) && method_exists($this, 'getPlaceholderText') ? $this->getPlaceholderText() : NULL;
	}

	public function getFactoryElementFieldChecked(array $allowed)
	{
		return in_array(FactoryElementAttribute::CHECKED->value, $allowed, TRUE) && method_exists($this, 'getElementFieldChecked') ? $this->getElementFieldChecked() : NULL;
	}

	public function getElementFieldValue()
	{
		$_value_type = $this->FactoryElementFieldValueType?->value ?? FactoryElementPrimativeType::STRING->value;
		$_field_prop = sprintf('FactoryElementField%sValue', ucfirst($_value_type));

		if (property_exists($this, $_field_prop)) {
			return $this->{$_field_prop};
		} else {
			return $this->FactoryElementFieldStringValue;
		}
	}

	public function getElementFieldValueType()
	{
		return $this->FactoryElementFieldValueType?->value;
	}

	public function getElementFieldType(): ?string
	{
		return $this->FactoryElementFieldType?->value;
	}

	/**
	 * Wrapped mode: `<label>` plus the `field-inner-label-wrapper` block (header and tooltip) when a label exists.
	 * Mirrors the TypeScript `UI_WrappedFieldLabel` part.
	 */
	public function getElementFieldLabelOpen(): string
	{
		return $this->usesFieldLabelTag() ? '<label' . $this->getElementFieldLabelAttributes() . '>' . $this->getElementFieldLabelWrapper() : '';
	}

	/** Extra attributes for the `<label>` tag (leading space included). Radios add the explicit `for`. */
	protected function getElementFieldLabelAttributes(): string
	{
		return '';
	}

	public function getElementFieldLabelWrapper(): string
	{
		return $this->FactoryElementFieldLabel ?
			sprintf(
				'<div class="field-inner-label-wrapper">%s%s<div class="clear"></div></div>',
				$this->getElementFieldLabel(),
				$this->getElementFieldTooltip()
			) : '';
	}

	/** Wrapped fields render a `<label>` around the inner wrapper; submit-style controls opt out. */
	protected function usesFieldLabelTag(): bool
	{
		return TRUE;
	}

	public function getElementFieldWrapperType(): string
	{
		$_type = $this->FactoryElementFieldType?->value;

		if ($_type === NULL) {
			return $this->FactoryElement?->value ?? '';
		}

		return match ($_type) {
			FactoryElementFieldType::PASSWORD->value => 'pw',
			default => $_type
		};
	}

	public function getElementFieldWrapperOpen(): string
	{
		return sprintf(
			'<div class="field-wrapper %s" data-field="%s">',
			$this->getElementFieldWrapperType(),
			$this->FactoryElementName ?? $this->getFactoryName() ?? $this->getFactoryId() ?? ''
		);
	}

	public function getElementFieldWrapperClose(): string
	{
		return '<div class="clear"></div></div>';
	}

	public function getElementFieldInnerWrapperOpen(): string
	{
		return '<div class="field-inner-wrapper">';
	}

	public function getElementFieldInnerWrapperClose(): string
	{
		return '<div class="clear"></div></div>';
	}

	/** The bare control markup. Subclasses override this hook, never the compile/build pipeline. */
	public function getElementFieldControl(): string
	{
		return $this->getElementOpen()
			. $this->getElementContent()
			. $this->getElementClose();
	}

	public function buildElementFieldControl(): void
	{
		$this->buildElementOpen();
		$this->buildElementContent();
		$this->buildElementClose();
	}

	public function getElementFieldUnwrappedLabelOpen(): string
	{
		return $this->FactoryElementFieldLabel ?
			sprintf('<label%s>%s', $this->getElementFieldLabelAttributes(), $this->FactoryElementFieldLabel) : '';
	}

	public function getElementFieldLabel(): string
	{
		return $this->FactoryElementFieldLabel ?
			sprintf(
				'<span class="fld-label-header">%s</span>',
				$this->FactoryElementFieldLabel
			) : '';
	}

	public function getElementFieldLabelUnwrapped(): string
	{
		return $this->FactoryElementFieldLabel ?? '';

	}

	public function getElementFieldLabelClose(): string
	{
		return $this->usesFieldLabelTag() ? '</label>' : '';
	}

	public function getElementFieldUnwrappedLabelClose(): string
	{
		return $this->FactoryElementFieldLabel ? '</label>' : '';
	}


	/**
	 * Tooltip = label explanation or description text. Rendered only in wrapped mode and only when a label exists;
	 * raw (unwrapped) fields render the label text alone.
	 */
	public function getElementFieldTooltip(): string
	{
		return $this->FactoryElementFieldTooltip ? sprintf('<span class="fld-label-tooltip">%s</span>', $this->FactoryElementFieldTooltip) : '';
	}


	public function getElementFieldLength(): ?string
	{
		return $this->FactoryElementFieldLength;

	}

	public function getElementFieldAccess(): ?bool
	{
		return $this->FactoryElementFieldAccess;

	}

	public function getElementFieldAction(): ?string
	{
		return $this->FactoryElementFieldAct;
	}

	public function getElementFieldset($params = []): ?FactoryElementFieldsetAbstract
	{
		if (!($this->FactoryElementFieldFieldset instanceof FactoryElementFieldsetAbstract)) {
			$this->FactoryElementFieldFieldset = new Fieldset($params);
		}
		return $this->FactoryElementFieldFieldset;
	}

	public function compileAsHtmlStringWithFieldset(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. ($this->getElementFieldset()->getElementLabel() ?? '')
			. $this->compileAsHtmlString()
			. $this->getElementFieldset()->getElementClose();
	}

	/** Wrapped (default) output: `div.field-wrapper > label > div.field-inner-wrapper > control`. */
	public function compileAsHtmlString(): ?string
	{
		return $this->getElementFieldWrapperOpen()
			. $this->getElementFieldLabelOpen()
			. $this->getElementFieldInnerWrapperOpen()
			. $this->getElementFieldControl()
			. $this->getElementFieldInnerWrapperClose()
			. $this->getElementFieldLabelClose()
			. $this->getElementFieldWrapperClose();
	}

	/** Raw output: `<label>text<control></label>` with no wrapper divs. */
	public function compileAsHtmlStringUnwrapped(): ?string
	{
		return $this->getElementFieldUnwrappedLabelOpen()
			. $this->getElementFieldControl()
			. $this->getElementFieldUnwrappedLabelClose();
	}

	public function compileAsHtmlStringUnwrappedWithFieldset(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. ($this->getElementFieldset()->getElementLabel() ?? '')
			. $this->compileAsHtmlStringUnwrapped()
			. $this->getElementFieldset()->getElementClose();
	}

	public function buildFieldWrapperOpen()
	{
		echo $this->getElementFieldWrapperOpen() . "\n\t";
	}

	public function buildFieldWrapperClose()
	{
		echo $this->getElementFieldWrapperClose() . "\n\t";
	}

	public function buildFieldInnerWrapperOpen()
	{
		echo $this->getElementFieldInnerWrapperOpen() . "\n\t";
	}

	public function buildFieldInnerWrapperClose()
	{
		echo $this->getElementFieldInnerWrapperClose() . "\n\t";
	}

	public function build()
	{
		$this->buildFieldWrapperOpen();
		$this->buildElementFieldLabelOpen();
		$this->buildFieldInnerWrapperOpen();
		$this->buildElementFieldControl();
		$this->buildFieldInnerWrapperClose();
		$this->buildElementFieldLabelClose();
		$this->buildFieldWrapperClose();
	}

	public function buildWithFieldset()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->getElementFieldset()->buildElementLabel();
		$this->build();
		$this->getElementFieldset()->buildElementClose();
	}

	public function buildUnwrapped()
	{
		$this->buildElementFieldUnwrappedLabelOpen();
		$this->buildElementFieldControl();
		$this->buildElementFieldUnwrappedLabelClose();
	}

	public function buildUnwrappedWithFieldset()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->getElementFieldset()->buildElementLabel();
		$this->buildUnwrapped();
		$this->getElementFieldset()->buildElementClose();
	}

	public function buildElementFieldLabelOpen()
	{
		echo $this->getElementFieldLabelOpen() . "\n\t";
	}

	public function buildElementFieldUnwrappedLabelOpen()
	{
		echo $this->getElementFieldUnwrappedLabelOpen() . "\n\t";
	}

	public function buildElementFieldUnwrappedLabelClose()
	{
		echo $this->getElementFieldUnwrappedLabelClose() . "\n\t";
	}

	public function buildElementFieldLabelUnwrapped()
	{
		echo $this->getElementFieldLabelUnwrapped() . "\n\t";
	}

	public function buildElementFieldLabelClose()
	{
		echo $this->getElementFieldLabelClose() . "\n\t";
	}

}

