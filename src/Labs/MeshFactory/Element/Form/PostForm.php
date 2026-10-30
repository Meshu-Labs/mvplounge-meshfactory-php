<?php

namespace MvpLounge\MeshFactory\Element\Form;


require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Abstract\FactoryElementFormAbstract;

require_once __DIR__ . '/../../Abstract/FactoryElementFormAbstract.php';
/**
 * POST form implementation.
 *
 * MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form
 */
class PostForm extends FactoryElementFormAbstract
{
	protected array $AllowedFactoryElements = [
		FactoryElement::FORM
	];

	protected ?array $FactoryElementUserClass = ['post-form'];

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

}

