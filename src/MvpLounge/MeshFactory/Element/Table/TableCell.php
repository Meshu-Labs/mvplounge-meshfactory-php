<?php

namespace MvpLounge\MeshFactory\Element\Table;



require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementTableAbstract;


require_once __DIR__ . '/../../Abstract/FactoryElementTableAbstract.php';

class TableCell extends FactoryElementTableAbstract
{
	protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE_CELL;
	protected ?string $FactoryElementSystemClass = 'generic-cell';

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	public function build()
	{
		echo $this->getElementOpen();
		echo $this->getElementContent();
		echo $this->getElementClose();
	}

	public function getFactoryModel(): array
	{
		return array_merge(
			parent::getFactoryModel(),
			[
				'content' => $this->FactoryElementContent
			]
		);
	}

	protected function __process_content($params): void
	{
		if (isset($params['content'])) {
			$this->FactoryElementContent = sprintf('<div class="content">%s</div>', $params['content']);
		}
	}

}


