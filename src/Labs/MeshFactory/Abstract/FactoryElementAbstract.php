<?php

namespace MvpLounge\MeshFactory\Abstract;


require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Abstract\FactoryAbstract;
use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;


require_once __DIR__ . '/FactoryAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElementWindowTarget.php';

abstract class FactoryElementAbstract extends FactoryAbstract
{

	protected array $AllowedFactoryElements = [];
	protected array $AllowedFactoryElementAttributes = [];
	protected ?FactoryElement $FactoryElement = NULL;
	protected ?string $FactoryElementClose = NULL;
	protected ?string $FactoryElementContent = '';
	protected ?string $FactoryElementName = NULL;
	protected ?string $FactoryElementOpen = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);

		if (is_countable($params) && array_key_exists('content', $params)) {
			$this->__process_content($params);
		}
	}

	protected function registerAllowedFactoryElementAttributeMap(): void
	{
		foreach ($this->AllowedFactoryElementAttributes as $allowedAttribute) {
			if ($allowedAttribute instanceof \BackedEnum) {
				$this->addFactoryAttributeEnumToMap($allowedAttribute, 'FactoryElement');
			}
		}
	}

	protected function __process_configuration($params): void
	{

		if (isset($params['configuration']) && is_array($params['configuration'])) {
			$this->FactoryElementConfiguration = $params['configuration'];
		}
	}

	protected function __process_content($params): void
	{

		if (isset($params['content'])) {
			$this->addContent($params['content'], TRUE);
		}
	}

	public function addContent($content, $overwrite = FALSE): static
	{
		if ($overwrite) {
			$this->FactoryElementContent = $content;
		} else {
			$this->FactoryElementContent = trim(implode(' ', array_filter([
				$this->FactoryElementContent,
				$content
			], static function ($value) {
				return is_string($value) && trim($value) !== '';
			})));
		}
		return $this;
	}

	protected function __process_data($params): void
	{

		if (isset($params['data']) && is_array($params['data'])) {
			$this->FactoryElementDataParams = $params['data'];
		}
	}

	protected function __process_element($params): void
	{

		if (isset($params['element'])) {
			$this->addElement($params['element']);
		}

	}

	public function addElement($element): static
	{
		if ($element instanceof FactoryElement) {
			$this->FactoryElement = $element;
			return $this;
		}

		if (is_string($element)) {
			$this->FactoryElement = FactoryElement::tryFrom(strtolower(trim($element)));
		}

		return $this;
	}

	protected function __process_ext($params): void
	{

		if (is_array($this->FactoryElementExtendedAttributes) && count($this->FactoryElementExtendedAttributes) > 0 && isset($params['ext']) && is_array($params['ext'])) {
			foreach ($params['ext'] as $_param => $params_data) {
				$_params_key = strtolower($_param);
				if (isset($this->FactoryElementExtendedAttributes[$_params_key])) {
					$this->FactoryElementExtendedAttributes[$_params_key] = $params_data;
				}
			}
		}
	}

	public function addId($id): static
	{
		$this->FactoryId = $id;
		return $this;
	}
	protected function __process_name($params): void
	{

		if (isset($params['name'])) {
			$this->addName($params['name']);
		}
	}

	public function addName($name): static
	{
		$this->FactoryName = $name;
		$this->FactoryElementName = $name;
		return $this;
	}

	protected function __process_system($params): void
	{

		if (isset($params['system'])) {
			$this->FactoryElementSystemClass = $params['system'];
		}
	}

	protected function __process_user($params): void
	{

		if (isset($params['user'])) {
			$this->addClass($params['user']);
		}
	}

	public function addClass($class): static
	{
		if (is_array($class)) {
			foreach ($class as $_class) {
				if (!$this->hasClass($_class)) {
					if (is_array($_class)) {
						continue;
					}
					$this->FactoryElementUserClass[] = $_class;
				}
			}
		} else {
			if (is_string($class)) {
				$_class = explode(' ', $class);
				if (is_array($_class)) {
					$this->addClass($_class);
				} else {
					$this->addClass($class);
				}
			}
		}
		return $this;
	}

	public function hasClass($class)
	{
		if (is_string($class) && in_array($class, $this->FactoryElementUserClass)) {
			return TRUE;
		}
	}

	public function addData($data = []): static
	{
		foreach ($data as $_data => $_data_var) {

			if (!is_string($_data)) {
				continue;
			}
			$this->FactoryElementDataParams[strtolower($_data)] = $_data_var;
		}
		return $this;
	}

	public function build()
	{
		$this->buildElementOpen();
		$this->buildElementContent();
		$this->buildElementClose();
	}

	public function buildElementOpen()
	{
		echo $this->getElementOpen() . "\n\t";
	}

	public function buildElementContent()
	{
		echo $this->getElementContent() . "\n\t";
	}

	public function buildElementClose()
	{
		echo $this->getElementClose() . "\n\t";
	}

	public function getElementOpen(): ?string
	{
		if (!is_null($this->FactoryElement)) {
			$this->addElementOpen();
		}
		return $this->FactoryElementOpen;
	}

	public function getElementContent(): ?string
	{
		return $this->FactoryElementContent;
	}

	public function getElementClose(): ?string
	{
		if (!is_null($this->FactoryElement)) {
			$this->addElementClose();
		}

		return $this->FactoryElementClose;
	}

	public function addElementOpen($params = []): void
	{
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementOpen = $this->getElementFactoryOpen($this->FactoryElement->value, $this->getFactoryAttributePropertyCollection());
		}
	}

	public function addElementClose(): void
	{
		if ($this->FactoryElement instanceof FactoryElement) {
			$this->FactoryElementClose = $this->getElementFactoryClose($this->FactoryElement->value);
		}
	}

	public function getFactoryModel(): array
	{

		return [
			'open' => $this->getElementOpen(),
			'content' => $this->getElementContent(),
			'close' => $this->getElementClose()
		];
	}

	public function getElementFactoryClose($element): string
	{

		$_e = $this->getElementFactory($element);
		if (!$_e) {
			return '';
		}

		return sprintf('</%s>', $_e);
	}

	public function getElementFactory($element): ?string
	{

		if (!is_string($element)) {
			return NULL;
		}

		$e = strtolower(trim($element));
		if ($e === '') {
			return NULL;
		}

		if (in_array($e, $this->getAllowedFactoryElementValues(), TRUE)) {
			return $e;
		}

		return NULL;
	}

	protected function getAllowedFactoryElementValues(): array
	{
		return array_values(array_filter(array_map(static function ($allowedElement) {
			if ($allowedElement instanceof FactoryElement) {
				return $allowedElement->value;
			}

			if (is_string($allowedElement)) {
				$_value = strtolower(trim($allowedElement));
				return $_value === '' ? NULL : $_value;
			}

			return NULL;
		}, $this->AllowedFactoryElements), static function ($value) {
			return is_string($value) && $value !== '';
		}));
	}

	public function getElementFactoryDefaultPropertiesFromParams($params): array
	{

		return [
			'id' => $this->getElementFactoryProperty('id', $params['id'] ?? NULL),
			'data' => $this->getElementFactoryProperty('data', $params['data'] ?? NULL),
			'class' => $this->getElementFactoryProperty('class', $this->getElementClassFromParams($params))
		];
	}

	protected function getElementClassFromParams($params): string
	{

		$_user = $params['user'] ?? [];
		if (is_string($_user)) {
			$_user = explode(' ', $_user);
		}

		if (!is_array($_user)) {
			$_user = [];
		}

		$_classes = [];
		foreach ($_user as $_class) {
			if (is_string($_class) && trim($_class) !== '') {
				$_classes[] = trim($_class);
			}
		}

		$_system = $params['system'] ?? NULL;
		if (is_string($_system) && trim($_system) !== '') {
			$_classes[] = trim($_system);
		}

		return implode(' ', $_classes);
	}

	public function getElementFactoryOpen($element, $params = []): string
	{

		$_e = $this->getElementFactory($element);
		if (!$_e) {
			return '';
		}

		$_model = $this->getElementFactoryDefaultPropertiesFromParams($params);

		foreach ($this->getFactoryElementAttributeValues() as $_attribute) {
			if (array_key_exists($_attribute, $params)) {
				$_model[$_attribute] = $this->getElementFactoryProperty($_attribute, $params[$_attribute]);
			}
		}

		if (isset($params['ext']) && is_array($params['ext'])) {
			foreach ($params['ext'] as $_ext_attribute => $_ext_value) {
				if (is_string($_ext_attribute)) {
					$_model[$_ext_attribute] = $this->getElementFactoryProperty($_ext_attribute, $_ext_value);
				}
			}
		}

		return $this->getElementFactoryOpenPropertiesString($_e, $_model);
	}

	public function getAllowedFactoryElementAttributes(): array
	{
		$_attributes = [];

		foreach ($this->AllowedFactoryElementAttributes as $allowedAttribute) {
			if ($allowedAttribute instanceof \BackedEnum) {
				$_attributes[] = strtolower((string) $allowedAttribute->value);
				continue;
			}

			if (is_string($allowedAttribute) && trim($allowedAttribute) !== '') {
				$_attributes[] = strtolower(trim($allowedAttribute));
			}
		}

		return array_values(array_unique($_attributes));
	}

	public function getElementFactoryOpenPropertiesString($element, $model): string
	{

		$_properties = [];

		if (is_array($model)) {
			foreach ($model as $_property) {
				if (is_string($_property) && trim($_property) !== '') {
					$_properties[] = trim($_property);
				}
			}
		}

		$_attributes = implode(' ', $_properties);
		if ($_attributes !== '') {
			return sprintf('<%s %s>', $element, $_attributes);
		}

		return sprintf('<%s>', $element);
	}

	protected function getElementFactoryProperty($attribute, $value): string
	{

		if (!is_string($attribute)) {
			return '';
		}

		$_attribute = strtolower(trim($attribute));
		if ($_attribute === '') {
			return '';
		}

		if (is_array($value)) {
			return $this->getElementFactoryArrayProperty($_attribute, $value);
		}

		return $this->getElementFactoryScalarProperty($_attribute, $value);
	}



	protected function getElementFactoryScalarProperty($attribute, $value): string
	{

		if (is_null($value)) {
			return '';
		}

		if (is_string($value)) {
			$_value = trim($value);
		} elseif (is_bool($value) || is_int($value) || is_float($value)) {
			$_value = $value;
		} else {
			return '';
		}

		if ($_value === '') {
			return '';
		}

		switch ($attribute) {
			case 'target':
				$_target = strtolower((string) $_value);
				switch ($_target) {
					case strtolower((string) FactoryElementWindowTarget::SELF->value):
					case strtolower((string) FactoryElementWindowTarget::BLANK->value):
					case strtolower((string) FactoryElementWindowTarget::PARENT->value):
					case strtolower((string) FactoryElementWindowTarget::TOP->value):
						$_value = $_target;
						break;
					default:
						$_value = strtolower((string) FactoryElementWindowTarget::SELF->value);
						break;
				}
				return sprintf('target="%s"', $_value);
			case 'selected':
				return is_bool($value) && $value ? 'selected' : '';
			case 'checked':
				return is_bool($value) && $value ? 'checked' : '';
			case 'access':
				return is_bool($value) && $value ? 'enabled' : 'disabled';
			default:
				return sprintf('%s="%s"', $attribute, $_value);
		}
	}

	protected function getElementFactoryArrayProperty($attribute, array $value): string
	{

		if ($attribute !== 'data') {
			return '';
		}

		$_data_properties = [];
		foreach ($value as $_data_key => $_data_value) {
			if (!is_string($_data_key) || trim($_data_key) === '' || is_null($_data_value) || is_array($_data_value) || is_object($_data_value)) {
				continue;
			}
			$_data_properties[] = sprintf('data-%s="%s"', strtolower(trim($_data_key)), $_data_value);
		}

		return implode(' ', $_data_properties);
	}

}

