<?php

namespace MvpLounge\MeshFactory\Abstract;

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;

require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';

class FactoryElementCopyAbstract extends FactoryElementAbstract {

	protected array $AllowedFactoryElements = [
		FactoryElement::P,
		FactoryElement::H1,
		FactoryElement::H2,
		FactoryElement::H3,
		FactoryElement::H4,
		FactoryElement::H5,
		FactoryElement::H6,
		FactoryElement::HL,
		FactoryElement::IMG
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::ALT,
		FactoryElementAttribute::SRC
	];
	protected ?string $FactoryElementCopyAlt = NULL;
	protected ?string $FactoryElementCopySrc = NULL;
	
	public function __construct($params = []) {
		parent::__construct($params);
	}		

	protected function __process_alt($params): void
	{
		if (isset($params['alt']) && is_string($params['alt'])) {
			$this->addAlt($params['alt']);
		}
	}

	protected function __process_src($params): void
	{
		if (isset($params['src']) && is_string($params['src'])) {
			$this->addSrc($params['src']);
		}
	}

	public function addAlt($alt): FactoryElementCopyAbstract
	{
		$this->FactoryElementCopyAlt = is_null($alt) ? NULL : (string) $alt;
		return $this;
	}

	public function addSrc($src): FactoryElementCopyAbstract
	{
		$this->FactoryElementCopySrc = is_null($src) ? NULL : (string) $src;
		return $this;
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'alt' => $this->getFactoryElementCopyAlt($_allowed),
				'src' => $this->getFactoryElementCopySrc($_allowed),
			]
		);
	}

	protected function getFactoryElementCopyAlt(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::ALT->value, $allowed, TRUE) ? $this->FactoryElementCopyAlt : NULL;
	}

	protected function getFactoryElementCopySrc(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::SRC->value, $allowed, TRUE) ? $this->FactoryElementCopySrc : NULL;
	}
}
