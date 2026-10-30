<?php

namespace MvpLounge\MeshFactory\Element\Table;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

require_once __DIR__ . '/TableCell.php';


class TableHeader extends TableCell
{
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE_HEADER_CELL;
	protected ?string $FactoryElementSystemClass = 'generic-th';

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

}


