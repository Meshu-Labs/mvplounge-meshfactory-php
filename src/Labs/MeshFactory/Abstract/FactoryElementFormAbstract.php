<?php

namespace MvpLounge\MeshFactory\Abstract;



require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;
use MvpLounge\MeshFactory\Element\Field\FormButton;
use MvpLounge\MeshFactory\Element\Field\HiddenInput;


require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Element/Form/FormButton.php';
require_once __DIR__ . '/../Element/Form/HiddenInput.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElementWindowTarget.php';




/**
 * Form element support for submission and autofill attributes.
 *
 * MDN element reference:
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form
 */
abstract class FactoryElementFormAbstract extends FactoryElementAbstract
{

	protected array $AllowedFactoryElements = [
		FactoryElement::FORM
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::ACTION,
		FactoryElementAttribute::METHOD,
		FactoryElementAttribute::ENCTYPE,
		FactoryElementAttribute::NOVALIDATE,
		FactoryElementAttribute::TARGET,
		FactoryElementAttribute::AUTOCOMPLETE
	];

	protected ?FactoryElement $FactoryElement = FactoryElement::FORM;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#action */
	protected ?string $FactoryElementFormAction = NULL;
	protected ?string $FactoryElementFormActivity = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#autocomplete */
	protected string $FactoryElementFormAuto = 'off';
	protected ?array $FactoryElementFormButtons = [];
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#enctype */
	protected ?string $FactoryElementFormEnc = NULL;
	protected ?array $FactoryElementFormHiddenVars = [];
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#method */
	protected string $FactoryElementFormMethod = 'post';
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#novalidate */
	protected ?string $FactoryElementFormNoValidate = NULL;
	protected ?array $FactoryElementFormSectionFields = [];
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#target */
	protected ?string $FactoryElementFormTarget = NULL;
	protected ?array $FactoryElementUserClass = ['generic-form'];

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_action($params): void
	{

		if (isset($params['action']) && !empty($params['action'])) {
			$this->addAction($params['action']);
		}
	}

	public function addAction($action): static
	{
		$this->FactoryElementFormAction = is_null($action) ? NULL : (string) $action;
		return $this;
	}

	protected function __process_autocomplete($params): void
	{
		if (isset($params['autocomplete']) && $params['autocomplete'] !== '') {
			$this->addAutoComplete($params['autocomplete']);
		}
	}

	protected function __process_enctype($params): void
	{
		if (isset($params['enctype']) && !empty($params['enctype'])) {
			$this->addEnc($params['enctype']);
		}
	}

	public function addEnc($enc): static
	{
		$this->FactoryElementFormEnc = is_null($enc) ? NULL : (string) $enc;
		return $this;
	}

	public function addEnctype($enctype): static
	{
		return $this->addEnc($enctype);
	}

	public function addAutoComplete($autoComplete): static
	{
		if (is_null($autoComplete)) {
			$this->FactoryElementFormAuto = 'off';
			return $this;
		}
		$_auto_complete = strtolower(trim((string) $autoComplete));
		$this->FactoryElementFormAuto = $_auto_complete === 'on' ? 'on' : 'off';
		return $this;
	}

	protected function __process_method($params): void
	{

		if (isset($params['method']) && !empty($params['method'])) {
			$this->addMethod($params['method']);
		}
	}

	public function addMethod($method): static
	{
		if (
			is_string($method) && in_array(strtolower($method), [
				'post',
				'get'
			], TRUE)
		) {
			$this->FactoryElementFormMethod = strtolower($method);
		}
		return $this;
	}

	protected function __process_novalidate($params): void
	{

		if (isset($params['novalidate']) && !empty($params['novalidate'])) {
			$this->addNoValidate($params['novalidate'] ?? '');
		}
	}

	public function addNoValidate($novalid): static
	{
		if (!is_null($novalid) && $novalid !== '') {
			$this->FactoryElementFormNoValidate = (string) $novalid;
		}

		return $this;
	}

	protected function __process_target($params): void
	{

		if (isset($params['target']) && !empty($params['target'])) {
			$this->addTarget($params['target']);
		}
	}

	public function addTarget($target): static
	{
		if (
			is_string($target) && in_array(strtolower($target), [
				FactoryElementWindowTarget::SELF->value,
				FactoryElementWindowTarget::BLANK->value,
				FactoryElementWindowTarget::PARENT->value,
				FactoryElementWindowTarget::TOP->value
			], TRUE)
		) {
			$this->FactoryElementFormTarget = strtolower($target);
		}
		return $this;
	}

	public function addActivity($action): static
	{
		$this->FactoryElementFormActivity = is_null($action) ? NULL : (string) $action;
		return $this;
	}

	public function addFormResetButton($value = '', $id = NULL, $user = NULL, $data = NULL, $fieldset = [], $system = NULL): static
	{
		return $this->addFormButton($value, 'reset', $id, $user, $data, $fieldset, $system);
	}

	public function addFormButton($value = '', $type = 'button', $id = NULL, $user = NULL, $data = NULL, $fieldset = [], $system = NULL): static
	{
		$this->FactoryElementFormButtons[(string) $type] = new FormButton([
			'value' => $value,
			'id' => $id,
			'user' => $user,
			'data' => $data,
			'system' => $system,
			'fieldset' => $fieldset,
			'type' => $type
		]);
		return $this;
	}

	public function addFormSectionFields($section = 'main', $namespace = NULL, $field = NULL): static
	{
		$_section = strtolower((string) $section);
		if (!isset($this->FactoryElementFormSectionFields[$_section])) {
			$this->FactoryElementFormSectionFields[$_section] = [];
		}

		if ($namespace !== NULL && $field !== NULL) {
			$this->FactoryElementFormSectionFields[$_section][(string) $namespace] = $field;
		}

		return $this;
	}

	public function addFormSubmitButton($value = '', $id = NULL, $user = NULL, $data = NULL, $fieldset = [], $system = NULL): static
	{
		return $this->addFormButton($value, 'submit', $id, $user, $data, $fieldset, $system);
	}

	public function addHiddenPostField($params): static
	{
		if (is_array($params)) {
			$this->FactoryElementFormHiddenVars[] = new HiddenInput($params);
		}

		return $this;
	}

	public function buildFormResetButton()
	{

		return $this->getFormResetButton()->build() . "\n\t";
	}

	public function build()
	{
		$this->buildElementOpen();
		$this->buildFormHiddenPostVars();
		$this->buildFormSectionFields();
		$this->buildFormSubmitButton();
		$this->buildElementClose();
	}

	public function getFormResetButton()
	{
		if (
			!isset($this->FactoryElementFormButtons['reset']) ||
			!($this->FactoryElementFormButtons['reset'] instanceof FormButton)
		) {
			$this->FactoryElementFormButtons['reset'] = new FormButton([
				'type' => 'reset',
				'value' => 'Reset',
				'user' => ['reset'],
				'fieldset' => [
					'id' => 'fieldset_reset',
					'user' => [
						'col ',
						'full'
					]
				]
			]);
		}
		return $this->FactoryElementFormButtons['reset'];
	}

	public function buildFormHiddenPostVars()
	{
		foreach ($this->getHiddenPostFields() as $_hidden) {
			echo $_hidden->build() . "\n\t";
		}
	}

	public function buildFormSectionFields($section = '')
	{

		$_field_sections = $this->getFormSectionFields($section);
		if (count($_field_sections['field'] ?? []) > 0) {
			$_field_sections['fieldset']->buildElementOpen();
			foreach ($_field_sections['field'] as $_fields) {
				if (is_array($_fields)) {
					$this->buildFormField($_fields);
				} elseif ($_fields instanceof FactoryElementFieldAbstract) {
					$_fields->build();
				} elseif (is_string($_fields)) {
					echo $_fields;
				}
			}
			$_field_sections['fieldset']->buildElementClose();
		}
	}

	public function buildFormSubmitButton()
	{
		echo $this->getFormSubmitButton()->asSubmit()->build() . "\n\t";
	}

	public function getHiddenPostFields(): ?array
	{
		return $this->FactoryElementFormHiddenVars;
	}

	public function getFormSectionFields($section = '')
	{

		if ($section !== '') {
			return $this->FactoryElementFormSectionFields[$section] ?? [];
		} else {
			return $this->FactoryElementFormSectionFields;
		}
	}

	protected function buildFormField($fields)
	{
		foreach ($fields as $_fl) {
			if (is_string($_fl)) {
				echo $_fl . "\n\t";
			} elseif ($_fl instanceof FactoryElementAbstract) {
				$_fl->build();
			}
		}
	}

	public function getFormSubmitButton()
	{

		if (
			!isset($this->FactoryElementFormButtons['submit']) ||
			!($this->FactoryElementFormButtons['submit'] instanceof FormButton)
		) {
			$this->FactoryElementFormButtons['submit'] = new FormButton(
				[
					'type' => 'submit',
					'value' => 'Submit',
					'user' => ['post'],
					'fieldset' => [
						'id' => 'fieldset_post_submit',
						'user' => [
							'col ',
							'full'
						]
					]
				]
			);
		}
		return $this->FactoryElementFormButtons['submit'];
	}

	protected function __process_name($params): void
	{

		if (isset($params['name']) && !empty($params['name'])) {
			$this->FactoryElementFormMethod = $params['name'];
		}
	}

	public function addElementClose(): void
	{
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementClose = $this->getElementFactoryClose($this->FactoryElement->value);
		}
	}

	public function addElementOpen($params = []): void
	{
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementOpen = $this->getElementFactoryOpen($this->FactoryElement->value, $this->getFactoryAttributePropertyCollection());
		}
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'action' => $this->getFactoryElementFormAction($_allowed),
				'method' => $this->getFactoryElementFormMethod($_allowed),
				'enctype' => $this->getFactoryElementFormEncodingTyre($_allowed),
				'novalidate' => $this->getFactoryElementFormNoValidate($_allowed),
				'target' => $this->getFactoryElementFormTarget($_allowed),
				'autocomplete' => $this->getFactoryElementFormAutoComplete($_allowed),
			]
		);
	}

	protected function getFactoryElementFormAction(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::ACTION->value, $allowed, TRUE) ? $this->getFormAction() : NULL;
	}

	protected function getFactoryElementFormMethod(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::METHOD->value, $allowed, TRUE) ? $this->getFormMethod() : NULL;
	}

	protected function getFactoryElementFormEncodingTyre(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::ENCTYPE->value, $allowed, TRUE) ? $this->getFormEncodingTyre() : NULL;
	}

	protected function getFactoryElementFormNoValidate(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::NOVALIDATE->value, $allowed, TRUE) ? $this->getFormNoValidate() : NULL;
	}

	protected function getFactoryElementFormTarget(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::TARGET->value, $allowed, TRUE) ? $this->getFormTarget() : NULL;
	}

	protected function getFactoryElementFormAutoComplete(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::AUTOCOMPLETE->value, $allowed, TRUE) ? $this->FactoryElementFormAuto : NULL;
	}
	public function getFormMethod(): string
	{
		return $this->FactoryElementFormMethod;
	}

	public function getFormEncodingTyre(): ?string
	{
		return $this->FactoryElementFormEnc;
	}

	public function getFormNoValidate(): ?string
	{
		return $this->FactoryElementFormNoValidate;
	}

	public function getFormTarget(): ?string
	{
		return $this->FactoryElementFormTarget;
	}

	public function getFormAction(): ?string
	{
		return $this->FactoryElementFormAction;
	}

	public function getFormHiddenVars(): ?array
	{
		return $this->FactoryElementFormHiddenVars;
	}

	public function compileFormResetButton()
	{
		echo $this->getFormResetButton()->compileAsArray();
	}

	public function compileAsArray(): ?array
	{
		return [
			'open' => $this->getElementOpen(),
			'hidden' => $this->compileFormHiddenVars(),
			'fields' => $this->compileFormFields(),
			'buttons' => $this->compileFormSubmitButton(),
			'close' => $this->getElementClose()
		];
	}

	// factor out complile() and replace all instances with compileAsArray()

	public function compile(): ?array
	{
		return $this->compileAsArray();
	}

	public function compileFormHiddenVars($string = FALSE): array
	{

		$_field_return = [];

		foreach ($this->getFormHiddenVars() as $_hidden) {
			$_fld_detail = $_hidden->compileAsArray();
			$_field_name = $_fld_detail['name'] ?? NULL;
			if (!is_string($_field_name) || trim($_field_name) === '') {
				$_field_name = sprintf('hidden_%s', count($_field_return));
			}
			$_field_return[$_field_name] = $string ? $_hidden->compileAsHtmlString() : ($_fld_detail['field'] ?? '');
		}

		return $_field_return;
	}

	public function compileFormFields($string = FALSE): array
	{

		$_field_return = [];

		foreach ($this->getFormSectionFields() as $_field_section_id => $_section) {

			if (!is_array($_section)) {
				continue;
			}

			if (count($_section) > 0) {
				$_field_return = array_merge($_field_return, [$_field_section_id => $this->compileFormSection($_section, $string)]);
			}
		}

		return $_field_return;
	}

	public function compileFormSubmitButton(): array
	{

		return $this->getFormSubmitButton()->asSubmit()->compileAsArray();
	}

	public function compileFormSection($section, $string = FALSE): array
	{

		$_field_return = [];

		if (count($section) <= 0) {
			return $_field_return;
		}

		foreach ($section as $_fld_index => $_field) {

			if ($_field instanceof FactoryElementFieldAbstract) {
				$_field_return[$_fld_index] = $string ? $_field->compileAsHtmlString() : $_field->compileAsArray();
			} else {
				$_field_return[$_fld_index] = $_field;
			}
		}

		return $_field_return;
	}

	public function getFactoryModel(): array
	{

		return [
			'open' => $this->getElementOpen(),
			'hidden' => $this->getFormHiddenVars(),
			'fields' => $this->getFormFields(),
			'buttons' => $this->getFormButtons(),
			'close' => $this->getElementClose()
		];
	}

	public function getFormFields(): array
	{

		$_fields = [];

		if (count($this->FactoryElementFormSectionFields) > 0) {
			foreach ($this->FactoryElementFormSectionFields as $field_section => $fields_section_array) {
				if (is_array($fields_section_array)) {
					foreach ($fields_section_array as $field_index => $field) {
						if (!isset($_fields[$field_section])) {
							$_fields[$field_section] = [];
						}
						$_fields[$field_section][$field_index] = $field;
					}
				}
			}
		}
		return $_fields;
	}

	public function getFormButtons(): array
	{

		$_buttons = [];

		if (count($this->FactoryElementFormButtons) > 0) {
			foreach ($this->FactoryElementFormButtons as $button_index => $button) {
				if ($button instanceof FormButton) {
					$_buttons[$button_index] = $button;
				}
			}
		}
		return $_buttons;
	}

	public function prepare(): array
	{
		return [
			'open' => $this->getElementOpen(),
			'hidden' => $this->compileFormHiddenVars(TRUE),
			'fields' => $this->compileFormFields(TRUE),
			'buttons' => $this->getFormSubmitButton()->compileAsHtmlString(),
			'close' => $this->getElementClose()
		];
	}

	public function compileAsJson(): ?string
	{
		$_payload = $this->prepare();
		$_json = json_encode($_payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		return is_string($_json) ? $_json : NULL;
	}

}

