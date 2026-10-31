<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;

require_once __DIR__ . '/FactoryElementFieldAbstract.php';
require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/FactoryElementFormElementsAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';

use MvpLounge\MeshFactory\Abstract\FactoryElementFieldAbstract;

abstract class FactoryElementFieldsetAbstract extends FactoryElementAbstract
{

	protected array $AllowedFactoryElements = [
		FactoryElement::FIELDSET
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::NAME,
		FactoryElementAttribute::ACCESS,
		FactoryElementAttribute::DISABLED,
		FactoryElementAttribute::FORM
	];
	protected ?FactoryElement $FactoryElement = FactoryElement::FIELDSET;
	protected ?string $FactoryElementSystemClass = 'generic-fieldset';
	protected ?string $FactoryElementFieldsetLegend = NULL;
	protected array $FieldElementFieldsetCollection = [];
	protected ?FactoryElementFormElementsAbstract $FactoryElementFieldsetLabel = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_params($params): void
	{
		parent::__process_params($params);
		if (is_array($params)) {
			$this->__process_user($params);
			$this->__process_legend($params);
			$this->__process_label($params);
		}
	}

	protected function __process_label($params): void
	{
		if (isset($params['label']) && $params['label'] !== '') {
			$this->addLabel($params['label']);
		}
	}

	/**
	 * Stores the label element rendered inside the fieldset.
	 * Accepts a label element, a text string, an array of label params, or NULL to clear it.
	 */
	public function addLabel($label): static
	{
		if (is_null($label)) {
			$this->FactoryElementFieldsetLabel = NULL;
			return $this;
		}

		if ($label instanceof FactoryElementFormElementsAbstract) {
			$this->FactoryElementFieldsetLabel = $label;
			return $this;
		}

		require_once __DIR__ . '/../Element/Form/FieldsetLabel.php';

		if (is_array($label)) {
			$this->FactoryElementFieldsetLabel = new \MvpLounge\MeshFactory\Element\Form\FieldsetLabel($label);
		} elseif (is_scalar($label) && trim((string) $label) !== '') {
			$this->FactoryElementFieldsetLabel = new \MvpLounge\MeshFactory\Element\Form\FieldsetLabel(['content' => trim((string) $label)]);
		}

		return $this;
	}

	public function getLabel(): ?FactoryElementFormElementsAbstract
	{
		return $this->FactoryElementFieldsetLabel;
	}

	public function getElementLabel(): ?string
	{
		return $this->FactoryElementFieldsetLabel?->compileAsHtmlString();
	}

	public function buildElementLabel()
	{
		$_label = $this->getElementLabel();
		if ($_label !== NULL) {
			echo $_label . "\n\t";
		}
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		return $this->getDefaultFactoryAttributePropertyCollection();
	}

	protected function __process_legend($params): void
	{
		if (isset($params['legend']) && $params['legend'] !== '') {
			$this->addLegend($params['legend']);
		}
	}

	public function addLegend($legend): static
	{
		if (is_null($legend)) {
			$this->FactoryElementFieldsetLegend = NULL;
			return $this;
		}

		$this->FactoryElementFieldsetLegend = trim((string) $legend);
		return $this;
	}

	public function addField($namespace, FactoryElementFieldAbstract $field, $override = true): static
	{
		if ($override || !isset($this->FieldElementFieldsetCollection[strtolower((string) $namespace)])) {
			$this->FieldElementFieldsetCollection[strtolower((string) $namespace)] = $field;
		}
		return $this;
	}

	public function addFieldCollection(array $fieldCollection): static
	{
		if (is_array($fieldCollection) && !empty($fieldCollection)) {
			foreach ($fieldCollection as $namespace => $field) {
				if ($field instanceof FactoryElementFieldAbstract) {
					$this->addField($namespace, $field);
				}
			}
		}
		return $this;
	}

	public function build()
	{
		$this->buildElementOpen();
		$this->buildElementContent();
		$this->buildElementClose();
	}

	public function compileAsArray(): array
	{
		return [
			'open' => $this->getElementOpen(),
			'legend' => $this->FactoryElementFieldsetLegend,
			'label' => $this->getElementLabel(),
			'fields' => $this->getElementContent(),
			'close' => $this->getElementClose()
		];
	}

	public function getElementContent(): ?string
	{
		$_content = '';
		if ($this->FactoryElementFieldsetLegend !== NULL && trim($this->FactoryElementFieldsetLegend) !== '') {
			$_content .= '<legend>' . htmlspecialchars($this->FactoryElementFieldsetLegend, ENT_QUOTES | ENT_HTML5) . '</legend>';
		}

		$_content .= $this->getElementLabel() ?? '';

		if (count($this->FieldElementFieldsetCollection) > 0) {
			foreach ($this->FieldElementFieldsetCollection as $_field) {
				if ($_field instanceof FactoryElementFieldAbstract) {
					$_content .= $_field->compileAsHtmlString();
				}
			}
		}

		return $_content !== '' ? $_content : NULL;
	}

}

