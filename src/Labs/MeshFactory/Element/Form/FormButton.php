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




class FormButton extends FactoryElementFieldInputAbstract
{
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::BUTTON;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::STRING;
	protected ?object $FactoryElementFieldFieldset = NULL;
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
	public function compile(): array
	{

		return [
			'field' => $this->getElementOpen(),
			'fieldset' => $this->getElementFieldset()->compileAsArray()
		];
	}



	public function compileAsHtmlString(): ?string
	{
		return $this->getElementFieldset()->getElementOpen()
			. $this->getElementOpen()
			. $this->getElementFieldset()->getElementClose();
	}

	public function string(): ?string
	{
		return $this->compileAsHtmlString();
	}

	public function build()
	{
		$this->getElementFieldset()->buildElementOpen();
		$this->buildElementOpen();
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
