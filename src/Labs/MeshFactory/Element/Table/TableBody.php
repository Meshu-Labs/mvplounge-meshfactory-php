<?php

namespace MvpLounge\MeshFactory\Element\Table;



require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Element\Table\TableRowBody;
use MvpLounge\MeshFactory\Abstract\FactoryElementTableAbstract;

require_once __DIR__ . '/TableHead.php';
require_once __DIR__ . '/TableFooter.php';
require_once __DIR__ . '/TableRowBody.php';
require_once __DIR__ . '/../../Abstract/FactoryElementTableAbstract.php';


class TableBody extends FactoryElementTableAbstract
{

	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::CELLSPACING,
		FactoryElementAttribute::CELLPADDING,
		FactoryElementAttribute::BORDER
	];
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE;
	protected ?string $FactoryElementSystemClass = 'generic-table';
	protected ?TableFooter $FactoryElementTableFooter = NULL;
	protected ?TableHead $FactoryElementTableHead = NULL;
	protected ?TableRowBody $FactoryElementTableRowBody = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	public function addHeader($content, $id = NULL, $user = NULL, $data = NULL, $extended = [], $system = NULL)
	{
		$this->getHeader()->addHeader($content, $id, $user, $data, $extended, $system);
		return $this;
	}

	public function getHeader($params = NULL): TableHead
	{
		if (!$this->FactoryElementTableHead or !($this->FactoryElementTableHead instanceof TableHead)) {
			$this->FactoryElementTableHead = new TableHead($params);
		}

		return $this->FactoryElementTableHead;
	}

	public function addRow($params = NULL)
	{
		return $this->getRowBody()->addRow($params);
	}

	public function getRowBody($params = NULL): TableRowBody
	{
		if (!$this->FactoryElementTableRowBody or !($this->FactoryElementTableRowBody instanceof TableRowBody)) {
			$this->FactoryElementTableRowBody = new TableRowBody($params);
		}

		return $this->FactoryElementTableRowBody;
	}

	public function build()
	{
		echo $this->getElementOpen() . "\n\t";
		echo $this->getHeader()->build() . "\n\t";
		echo $this->getRowBody()->build() . "\n\t";
		echo $this->getFooter()->build() . "\n\t";
		echo $this->getElementClose() . "\n\t";
	}

	public function getFooter($params = NULL): TableFooter
	{
		if (!$this->FactoryElementTableFooter or !($this->FactoryElementTableFooter instanceof TableFooter)) {
			$this->FactoryElementTableFooter = new TableFooter($params);
		}

		return $this->FactoryElementTableFooter;
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'cellspacing' => $this->getFactoryElementTableCellspacing($_allowed),
				'cellpadding' => $this->getFactoryElementTableCellpadding($_allowed),
				'border' => $this->getFactoryElementTableBorder($_allowed),
			]
		);
	}

	public function getFactoryModel(): array
	{
		return
			[
				'open' => $this->getElementOpen(),
				'thead' => $this->getHeader()->compileAsArray(),
				'tbody' => $this->getRowBody()->compileAsArray(),
				'tfoot' => $this->getFooter()->compileAsArray(),
				'close' => $this->getElementClose()
			];
	}
}


