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




class FormButton extends FactoryElementFieldInputAbstract
{
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::BUTTON;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::STRING;
	protected ?FactoryElementFieldsetAbstract $FactoryElementFieldFieldset = NULL;
	protected ?array $FactoryElementUserClass = ['post'];

	public function __construct($params = [])
	{

		parent::__construct($params);

	}

	public function asButton()
	{
		$this->FactoryElementFieldType = FactoryElementFieldType::BUTTON;
		return $this;
	}

	public function asSubmit()
	{
		$this->FactoryElementFieldType = FactoryElementFieldType::SUBMIT;
		return $this;
	}

	protected function usesFieldLabelTag(): bool
	{
		return $this->FactoryElementFieldType !== FactoryElementFieldType::SUBMIT;
	}

	public function compileAsHtmlString(): ?string
	{
		return $this->compileAsHtmlStringWithFieldset();
	}

	public function compileAsHtmlStringWithFieldset(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. ($this->getElementFieldset()->getElementLabel() ?? '')
			. parent::compileAsHtmlString()
			. $this->getElementFieldset()->getElementClose();
	}

	public function compileAsHtmlStringUnwrapped(): ?string
	{
		return $this->compileAsHtmlStringUnwrappedWithFieldset();
	}

	public function compileAsHtmlStringUnwrappedWithFieldset(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. ($this->getElementFieldset()->getElementLabel() ?? '')
			. $this->getElementFieldUnwrappedLabelOpen()
			. $this->getElementFieldControl()
			. $this->getElementFieldUnwrappedLabelClose()
			. $this->getElementFieldset()->getElementClose();
	}

	public function build()
	{
		$this->buildWithFieldset();
	}

	public function buildWithFieldset()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->getElementFieldset()->buildElementLabel();
		parent::build();
		$this->getElementFieldset()->buildElementClose();
	}

	public function buildUnwrapped()
	{
		$this->buildUnwrappedWithFieldset();
	}

	public function buildUnwrappedWithFieldset()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->getElementFieldset()->buildElementLabel();
		$this->buildElementFieldUnwrappedLabelOpen();
		$this->buildElementFieldControl();
		$this->buildElementFieldUnwrappedLabelClose();
		$this->getElementFieldset()->buildElementClose();
	}

	public function getFactoryModel(): array
	{
		return [
			'field' => $this->getElementOpen(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}

}
