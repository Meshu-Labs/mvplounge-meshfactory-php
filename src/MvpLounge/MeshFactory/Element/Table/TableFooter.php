<?php
	
	namespace MvpLounge\MeshFactory\Element\Table;

	
require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementTableAbstract;
	
	
require_once __DIR__ . '/TableHead.php';
require_once __DIR__ . '/../../Abstract/FactoryElementTableAbstract.php';

	
	class TableFooter extends FactoryElementTableAbstract {
		
		protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE_FOOT;
		protected ?string $FactoryElementSystemClass = 'generic-footer';
		
		public function __construct($params = []) {
			
			parent::__construct($params);
			
		}
		
	}

