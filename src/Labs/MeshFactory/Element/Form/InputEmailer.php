<?php

namespace MvpLounge\MeshFactory\Element\Field;

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementFieldType;
use MvpLounge\MeshFactory\Abstract\FactoryElementFieldsetAbstract;



require_once __DIR__ . '/InputText.php';
require_once __DIR__ . '/../../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../../Enum/FactoryElementFieldType.php';


class InputEmailer extends InputText
{

	protected array $AllowedFactoryElements = [
		FactoryElement::INPUT
	];
	protected ?FactoryElement $FactoryElement = FactoryElement::INPUT;
	protected ?FactoryElementFieldType $FactoryElementFieldType = FactoryElementFieldType::EMAIL;
	protected ?FactoryElementFieldsetAbstract $FactoryElementFieldFieldset = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

}