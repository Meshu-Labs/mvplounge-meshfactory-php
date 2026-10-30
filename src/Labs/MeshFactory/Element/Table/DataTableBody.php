<?php
	
	namespace MvpLounge\MeshFactory\Element\Table;
	
	

require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

require_once __DIR__ . '/TableBody.php';

	
	class DataTableBody extends TableBody {
		
		public function __construct($params = []) {
			
			parent::__construct($params);
			
		}
		
		public function build() {
			
			echo $this->getElementOpen() . "\n\t";
			echo $this->getHeader()->build() . "\n\t";
			echo $this->getRowBody()->build() . "\n\t";
			// echo $this->getFooter()->build() . "\n\t";
			echo $this->getElementClose() . "\n\t";
			
		}
		
		public function getFactoryModel() : array {
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

