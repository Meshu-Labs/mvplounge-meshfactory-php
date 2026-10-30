<?php

namespace MvpLounge\MeshFactory\Element\Form;



require_once __DIR__ . '/../../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Element\Field\FormButton;

require_once __DIR__ . '/../Form/PostForm.php';




/**
 * Button-driven form variation for Ajax submission flows.
 *
 * MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form
 */
class AjaxForm extends PostForm
{
	protected array $AllowedFactoryElements = [
		FactoryElement::FORM
	];

	protected ?array $FactoryElementUserClass = ['ajax-form'];

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	public function buildFormSubmitButton()
	{

		echo $this->getFormSubmitButton()->asButton()->build() . "\n\t";
	}

	public function getFormSubmitButton()
	{

		if (
			!isset($this->FactoryElementFormButtons['submit']) ||
			!($this->FactoryElementFormButtons['submit'] instanceof FormButton)
		) {
			$this->FactoryElementFormButtons['submit'] = new FormButton(
				[
					'type' => 'button',
					'value' => 'Submit',
					'user' => ['ajx'],
					'fieldset' => [
						'user' => [
							'col',
							'full'
						]
					]
				]
			);
		}
		return $this->FactoryElementFormButtons['submit'];
	}

	public function compileFormSubmitButton(): array
	{

		return $this->getFormSubmitButton()->asButton()->compileAsArray();
	}

}

