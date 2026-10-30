<?php

namespace MvpLounge\MeshFactory\Abstract;



require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElement;


require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';


/**
 * Table element support for tabular semantics and spanning attributes.
 *
 * MDN element reference:
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/table
 */
class FactoryElementTableAbstract extends FactoryElementAbstract
{
	protected array $AllowedFactoryElements = [
		FactoryElement::TABLE,
		FactoryElement::TABLE_BODY,
		FactoryElement::TABLE_ROW,
		FactoryElement::TABLE_CELL,
		FactoryElement::TABLE_HEADER_CELL,
		FactoryElement::TABLE_FOOT,
		FactoryElement::TABLE_HEAD
	];

	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::BORDER,
		FactoryElementAttribute::CELLSPACING,
		FactoryElementAttribute::CELLPADDING,
		FactoryElementAttribute::COLSPAN,
		FactoryElementAttribute::ROWSPAN,
		FactoryElementAttribute::SCOPE,
		FactoryElementAttribute::HEADERS,
		FactoryElementAttribute::ABBR
	];
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/td#colspan */
	protected $FactoryElementTableColspan = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/td#rowspan */
	protected $FactoryElementTableRowspan = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/th#scope */
	protected ?string $FactoryElementTableScope = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/td#headers */
	protected ?string $FactoryElementTableHeaders = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/th#abbr */
	protected ?string $FactoryElementTableAbbr = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/table#cellspacing */
	protected $FactoryElementTableCellspacing = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/table#cellpadding */
	protected $FactoryElementTableCellpadding = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/table#border */
	protected $FactoryElementTableBorder = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_colspan($params): void
	{
		if (array_key_exists('colspan', $params)) {
			$this->addColspan($params['colspan']);
		}
	}

	protected function __process_rowspan($params): void
	{
		if (array_key_exists('rowspan', $params)) {
			$this->addRowspan($params['rowspan']);
		}
	}

	protected function __process_scope($params): void
	{
		if (array_key_exists('scope', $params)) {
			$this->addScope($params['scope']);
		}
	}

	protected function __process_headers($params): void
	{
		if (array_key_exists('headers', $params)) {
			$this->addHeaders($params['headers']);
		}
	}

	protected function __process_abbr($params): void
	{
		if (array_key_exists('abbr', $params)) {
			$this->addAbbr($params['abbr']);
		}
	}

	protected function __process_cellspacing($params): void
	{
		if (array_key_exists('cellspacing', $params)) {
			$this->addCellspacing($params['cellspacing']);
		}
	}

	protected function __process_cellpadding($params): void
	{
		if (array_key_exists('cellpadding', $params)) {
			$this->addCellpadding($params['cellpadding']);
		}
	}

	protected function __process_border($params): void
	{
		if (array_key_exists('border', $params)) {
			$this->addBorder($params['border']);
		}
	}

	public function addColspan($colspan): static
	{
		$this->FactoryElementTableColspan = $colspan;
		return $this;
	}

	public function addRowspan($rowspan): static
	{
		$this->FactoryElementTableRowspan = $rowspan;
		return $this;
	}

	public function addScope($scope): static
	{
		if (is_null($scope)) {
			$this->FactoryElementTableScope = NULL;
			return $this;
		}
		$this->FactoryElementTableScope = (string) $scope;
		return $this;
	}

	public function addHeaders($headers): static
	{
		if (is_null($headers)) {
			$this->FactoryElementTableHeaders = NULL;
			return $this;
		}
		$this->FactoryElementTableHeaders = (string) $headers;
		return $this;
	}

	public function addAbbr($abbr): static
	{
		if (is_null($abbr)) {
			$this->FactoryElementTableAbbr = NULL;
			return $this;
		}
		$this->FactoryElementTableAbbr = (string) $abbr;
		return $this;
	}

	public function addCellspacing($cellspacing): static
	{
		$this->FactoryElementTableCellspacing = $cellspacing;
		return $this;
	}

	public function addCellpadding($cellpadding): static
	{
		$this->FactoryElementTableCellpadding = $cellpadding;
		return $this;
	}

	public function addBorder($border): static
	{
		$this->FactoryElementTableBorder = $border;
		return $this;
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

	public function getElementFactoryOpen($element, $params = []): string
	{

		$_e = $this->getElementFactory($element);
		if (!$_e) {
			return '';
		}

		$_model = $this->getElementFactoryDefaultPropertiesFromParams($params);

		foreach ($this->FactoryElementAttributeMap as $_attribute) {
			if (array_key_exists($_attribute, $params)) {
				$_model[$_attribute] = $this->getElementFactoryProperty($_attribute, $params[$_attribute]);
			}
		}

		switch ($_e) {
			case 'table':
				$_model['cellspacing'] = $this->getElementFactoryProperty('cellspacing', $params['cellspacing'] ?? NULL);
				$_model['cellpadding'] = $this->getElementFactoryProperty('cellpadding', $params['cellpadding'] ?? NULL);
				$_model['border'] = $this->getElementFactoryProperty('border', $params['border'] ?? NULL);
				break;
			case 'td':
				$_model['colspan'] = $this->getElementFactoryProperty('colspan', $params['colspan'] ?? NULL);
				$_model['rowspan'] = $this->getElementFactoryProperty('rowspan', $params['rowspan'] ?? NULL);
				$_model['headers'] = $this->getElementFactoryProperty('headers', $params['headers'] ?? NULL);
				break;
			case 'th':
				$_model['colspan'] = $this->getElementFactoryProperty('colspan', $params['colspan'] ?? NULL);
				$_model['rowspan'] = $this->getElementFactoryProperty('rowspan', $params['rowspan'] ?? NULL);
				$_model['scope'] = $this->getElementFactoryProperty('scope', $params['scope'] ?? NULL);
				$_model['headers'] = $this->getElementFactoryProperty('headers', $params['headers'] ?? NULL);
				$_model['abbr'] = $this->getElementFactoryProperty('abbr', $params['abbr'] ?? NULL);
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
				'colspan' => $this->getFactoryElementTableColspan($_allowed),
				'rowspan' => $this->getFactoryElementTableRowspan($_allowed),
				'scope' => $this->getFactoryElementTableScope($_allowed),
				'headers' => $this->getFactoryElementTableHeaders($_allowed),
				'abbr' => $this->getFactoryElementTableAbbr($_allowed),
				'cellspacing' => $this->getFactoryElementTableCellspacing($_allowed),
				'cellpadding' => $this->getFactoryElementTableCellpadding($_allowed),
				'border' => $this->getFactoryElementTableBorder($_allowed),
			]
		);
	}

	public function getFactoryElementTableColspan(array $allowed): mixed
	{
		return in_array(FactoryElementAttribute::COLSPAN->value, $allowed, TRUE) ? $this->FactoryElementTableColspan : NULL;
	}

	public function getFactoryElementTableRowspan(array $allowed): mixed
	{
		return in_array(FactoryElementAttribute::ROWSPAN->value, $allowed, TRUE) ? $this->FactoryElementTableRowspan : NULL;
	}

	public function getFactoryElementTableScope(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::SCOPE->value, $allowed, TRUE) ? $this->FactoryElementTableScope : NULL;
	}

	public function getFactoryElementTableHeaders(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::HEADERS->value, $allowed, TRUE) ? $this->FactoryElementTableHeaders : NULL;
	}

	public function getFactoryElementTableAbbr(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::ABBR->value, $allowed, TRUE) ? $this->FactoryElementTableAbbr : NULL;
	}

	public function getFactoryElementTableCellspacing(array $allowed): mixed
	{
		return in_array(FactoryElementAttribute::CELLSPACING->value, $allowed, TRUE) ? $this->FactoryElementTableCellspacing : NULL;
	}

	public function getFactoryElementTableCellpadding(array $allowed): mixed
	{
		return in_array(FactoryElementAttribute::CELLPADDING->value, $allowed, TRUE) ? $this->FactoryElementTableCellpadding : NULL;
	}

	public function getFactoryElementTableBorder(array $allowed): mixed
	{
		return in_array(FactoryElementAttribute::BORDER->value, $allowed, TRUE) ? $this->FactoryElementTableBorder : NULL;
	}
}

