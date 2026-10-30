<?php

namespace MvpLounge\MeshFactory\Element\Field;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementFieldType;
use MvpLounge\MeshFactory\Abstract\FactoryElementFieldInputAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementFieldInputAbstract.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementFieldType.php';




/**
 * Text-like input control with placeholder support.
 *
 * MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input
 */
class TextInput extends FactoryElementFieldInputAbstract
{

	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::TEXT;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes/placeholder */
	protected ?string $FactoryElementFieldPlaceholder = NULL;
	protected ?object $FactoryElementFieldFieldset = NULL;
	protected ?string $FactoryElementSystemClass = 'field_ui';

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_rlaceholder($params = []): void
	{
		$this->__process_placeholder($params);
	}

	protected function __process_placeholder($params = []): void
	{
		if (isset($params['placeholder']) && is_string($params['placeholder'])) {
			$this->addPlaceholder($params['placeholder']);
		}
	}

	public function addElementClose(): void
	{
	}

	public function build()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->buildElementLabelOpen();
		$this->buildElementOpen();
		$this->buildElementClose();
		$this->buildElementLabelClose();
		$this->getElementFieldset()->buildElementClose();

	}

	public function getFactoryModel(): array
	{

		return [
			'field' => $this->getElementOpen(),
			'labelOpen' => $this->getElementFieldLabelOpen(),
			'labelClose' => $this->getElementFieldLabelClose(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

	public function getPlaceholderText(): ?string
	{
		return $this->FactoryElementFieldPlaceholder;
	}

	public function addPlaceholder($text): static
	{
		$this->FactoryElementFieldPlaceholder = $text;
		return $this;
	}

}
