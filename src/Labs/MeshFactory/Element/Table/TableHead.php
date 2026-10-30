<?php

namespace MvpLounge\MeshFactory\Element\Table;



require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Element\Table\TableRow;
use MvpLounge\MeshFactory\Abstract\FactoryElementTableAbstract;

require_once __DIR__ . '/TableRow.php';
require_once __DIR__ . '/../../Abstract/FactoryElementTableAbstract.php';




class TableHead extends FactoryElementTableAbstract
{

	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE_HEAD;
	protected ?string $FactoryElementSystemClass = 'generic-thead';
	protected ?TableRow $FactoryElementTableHeaderRow = NULL;

	public function __construct($params = [])
	{

		parent::__construct($params);

	}

	public function addHeader($content, $id = NULL, $user = NULL, $data = NULL, $extended = [], $system = NULL)
	{

		$this->getHeaderRow()->addHeader($content, $id, $user, $data, $extended, $system);
		return $this;
	}

	protected function getHeaderRow($params = NULL): ?TableRow
	{
		if (!$this->FactoryElementTableHeaderRow or !($this->FactoryElementTableHeaderRow instanceof TableRow)) {
			$this->FactoryElementTableHeaderRow = new TableRow($params);
		}
		return $this->FactoryElementTableHeaderRow;
	}

	public function build()
	{

		echo $this->getElementOpen() . "\n\t";
		$this->getHeaderRow()->build() . "\n\t";
		echo $this->getElementOpen() . "\n\t";
	}

	public function getFactoryModel(): array
	{
		return array_merge(
			parent::getFactoryModel(),
			[
				'headers' => $this->getHeaderRow()->compileAsArray()

			]
		);
	}

}

