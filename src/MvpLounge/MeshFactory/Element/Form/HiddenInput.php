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




class HiddenInput extends FactoryElementFieldInputAbstract
{
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::HIDDEN;
	protected ?FactoryElementPrimativeType $FactoryElementFieldValueType = FactoryElementPrimativeType::STRING;
	protected ?object $FactoryElementFieldFieldset = NULL;

	public function __construct($params = [])
	{

		parent::__construct($params);

	}

	public function compileAsHtmlString(): ?string
	{
		return $this->getElementOpen() . $this->getElementContent() . $this->getElementClose();
	}

	public function string(): ?string
	{
		return $this->compileAsHtmlString();
	}

}
