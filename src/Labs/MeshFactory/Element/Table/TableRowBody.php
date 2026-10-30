<?php

namespace MvpLounge\MeshFactory\Element\Table;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryElementTableAbstract;

require_once __DIR__ . '/TableRow.php';
require_once __DIR__ . '/../../Abstract/FactoryElementTableAbstract.php';


	class TableRowBody extends FactoryElementTableAbstract {
		
		protected ?\MvpLounge\MeshFactory\Enum\FactoryElement $FactoryElement = \MvpLounge\MeshFactory\Enum\FactoryElement::TABLE_BODY;
		protected ?string $FactoryElementSystemClass = 'generic-tbody';
		protected ?array $FactoryElementTableRows = [];
		
		public function __construct($params = []) {
			
			parent::__construct($params);
			
		}
		
		public function addRow($params = NULL) : ?TableRow {
			$_count = 0;
			
			if(count($this->FactoryElementTableRows) > 0) {
				$_count = count($this->FactoryElementTableRows);
			}
			$this->FactoryElementTableRows[$_count] = new TableRow($params);
			return $this->FactoryElementTableRows[$_count];
		}
		
		public function build() {
			
			echo $this->getElementOpen();
			foreach($this->FactoryElementTableRows as $TableRow) {
				$TableRow->build();
			}
			echo $this->getElementClose();
		}
		
		public function getFactoryModel() : array {
			
			$_content = [
				 'rows' => []
			];
			
			foreach($this->FactoryElementTableRows as $TableRow) {
				$_content['rows'][] = $TableRow->compileAsArray();
			}
			
			return array_merge(parent::getFactoryModel(), $_content);
		}
		
	}

