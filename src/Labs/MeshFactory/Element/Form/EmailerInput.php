<?php

namespace MvpLounge\MeshFactory\Element\Field;

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementFieldType;



require_once __DIR__ . '/TextInput.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementFieldType.php';


class EmailerInput extends TextInput
{

	protected array $AllowedFactoryElements = [
		FactoryElement::INPUT
	];
	protected ?FactoryElement $FactoryElement = FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::EMAIL;
	protected ?object $FactoryElementFieldFieldset = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

}