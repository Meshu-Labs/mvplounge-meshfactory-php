<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;


abstract class FactoryAbstract
{
	public const DEFAULT_CONFIGURATION = [];
	protected array $FactoryElementAttributes = [
		FactoryElementAttribute::ID,
		FactoryElementAttribute::HTML_CLASS,
		FactoryElementAttribute::TITLE,
		FactoryElementAttribute::STYLE,
		FactoryElementAttribute::LANG,
		FactoryElementAttribute::DIR,
		FactoryElementAttribute::HIDDEN,
		FactoryElementAttribute::TABINDEX,
		FactoryElementAttribute::DRAGGABLE,
		FactoryElementAttribute::CONTENTEDITABLE,
		FactoryElementAttribute::SPELLCHECK,
		FactoryElementAttribute::TRANSLATE,
		FactoryElementAttribute::ROLE,
		FactoryElementAttribute::ARIA_LABEL,
		FactoryElementAttribute::ARIA_LABELLEDBY,
		FactoryElementAttribute::ARIA_DESCRIBEDBY
	];
	protected array $FactoryElementAttributeMap = [];
	protected ?array $FactoryElementConfiguration = NULL;
	protected ?array $FactoryElementDataParams = [];
	protected ?array $FactoryElementExtendedAttributes = NULL;
	protected ?array $FactoryElementLanguageVars = [];
	protected ?string $FactoryElementSystemClass = NULL;
	protected ?array $FactoryElementUserClass = [];
	protected $FactoryConfiguration;
	protected $FactoryId;
	protected $FactoryName;
	protected $FactoryClass;
	protected $FactoryTitle;
	protected $FactoryStyle;
	protected $FactoryLang;
	protected $FactoryDir;
	protected $FactoryHidden;
	protected $FactoryTabindex;
	protected $FactoryDraggable;
	protected $FactoryContenteditable;
	protected $FactorySpellcheck;
	protected $FactoryTranslate;
	protected ?string $FactoryRole = NULL;
	protected ?string $FactoryAriaLabel = NULL;
	protected ?string $FactoryAriaLabelledby = NULL;
	protected ?string $FactoryAriaDescribedby = NULL;

	public function __construct($params = [])
	{
		$this->__process_params($params);
	}

	protected function initializeFactoryAttributeMap(): void
	{
		$this->FactoryElementAttributeMap = [];
		$this->registerFactoryAttributeMap();
	}

	protected function __process_params($params): void
	{
		if (!is_countable($this->FactoryElementAttributeMap) || count($this->FactoryElementAttributeMap) === 0) {
			$this->initializeFactoryAttributeMap();
		}

		if (!is_countable($params)) {
			return;
		}

		foreach ($this->FactoryElementAttributeMap as $_attribute_property_check => $_attribute_value) {
			if (!is_string($_attribute_property_check) || !is_string($_attribute_value) || $_attribute_value === '') {
				continue;
			}

			$_attribute_method_check = sprintf('__process_%s', strtolower(str_replace(['-', '_'], '', $_attribute_value)));
			if (!array_key_exists($_attribute_value, $params)) {
				continue;
			}

			if (method_exists($this, $_attribute_method_check)) {
				$this->{$_attribute_method_check}($params);
				continue;
			}

			if (property_exists($this, $_attribute_property_check)) {
				$this->{$_attribute_property_check} = $params[$_attribute_value];
			}
		}
	}

	protected function registerFactoryElementAttributeMap(): void
	{
		foreach ($this->FactoryElementAttributes as $_attribute) {
			if ($_attribute instanceof \BackedEnum) {
				$this->addFactoryAttributeEnumToMap($_attribute, 'Factory');
			}
		}
	}

	protected function registerFactoryAttributeMap(): void
	{
		$this->registerFactoryElementAttributeMap();
		$this->registerAllowedFactoryElementAttributeMap();
	}

	protected abstract function registerAllowedFactoryElementAttributeMap(): void;


	public function getFactoryAttributePropertyCollection(): array
	{
		return [
			'id' => $this->FactoryId,
			'name' => $this->FactoryName,
			'class' => $this->FactoryClass,
			'title' => $this->FactoryTitle,
			'style' => $this->FactoryStyle,
			'lang' => $this->FactoryLang,
			'dir' => $this->FactoryDir,
			'hidden' => $this->FactoryHidden,
			'tabindex' => $this->FactoryTabindex,
			'draggable' => $this->FactoryDraggable,
			'contenteditable' => $this->FactoryContenteditable,
			'spellcheck' => $this->FactorySpellcheck,
			'translate' => $this->FactoryTranslate,
			'role' => $this->FactoryRole,
			'aria-label' => $this->FactoryAriaLabel,
			'aria-labelledby' => $this->FactoryAriaLabelledby,
			'aria-describedby' => $this->FactoryAriaDescribedby
		];
	}

	protected function getFactoryElementAttributeValues(): array
	{
		if (count($this->FactoryElementAttributeMap) === 0) {
			$this->initializeFactoryAttributeMap();
		}

		return array_values($this->FactoryElementAttributeMap);
	}


	protected function addFactoryAttributeEnumToMap(\BackedEnum $attribute, string $propertyPrefix = 'Factory'): void
	{
		$_attribute_machine_name = str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', str_replace('-', '_', $attribute->name)))));
		$_attribute_property_check = sprintf('%s%s', $propertyPrefix, $_attribute_machine_name);
		if ($_attribute_property_check === 'FactoryHtmlClass') {
			$_attribute_property_check = 'FactoryClass';
		}

		$this->FactoryElementAttributeMap[$_attribute_property_check] = strtolower((string) $attribute->value);
	}

	public function addId($id): static
	{
		$this->FactoryId = $id;
		return $this;
	}

	public function addClass($class): static
	{
		$this->FactoryClass = $class;
		return $this;
	}

	public function addTitle($title): static
	{
		$this->FactoryTitle = $title;
		return $this;
	}

	public function addStyle($style): static
	{
		$this->FactoryStyle = $style;
		return $this;
	}
	public function addLang($lang): static
	{
		$this->FactoryLang = $lang;
		return $this;
	}
	public function addDir($dir): static
	{
		$this->FactoryDir = $dir;
		return $this;
	}
	public function addHidden($hidden): static
	{
		$this->FactoryHidden = $hidden;
		return $this;
	}
	public function addTabindex($tabindex): static
	{
		$this->FactoryTabindex = $tabindex;
		return $this;
	}
	public function addDraggable($draggable): static
	{
		$this->FactoryDraggable = $draggable;
		return $this;
	}
	public function addContenteditable($contenteditable): static
	{
		$this->FactoryContenteditable = $contenteditable;
		return $this;
	}
	public function addSpellcheck($spellcheck): static
	{
		$this->FactorySpellcheck = $spellcheck;
		return $this;
	}
	public function addTranslate($translate): static
	{
		$this->FactoryTranslate = $translate;
		return $this;
	}
	public function addRole($role): static
	{
		$this->FactoryRole = $role;
		return $this;
	}
	public function addAriaLabel($label): static
	{
		$this->FactoryAriaLabel = $label;
		return $this;
	}
	public function addAriaLabelledby($labelledby): static
	{
		$this->FactoryAriaLabelledby = $labelledby;
		return $this;
	}
	public function addAriaDescribedby($describedby): static
	{
		$this->FactoryAriaDescribedby = $describedby;
		return $this;
	}
	public function compileAsArray(): ?array
	{
		$_model = $this->getFactoryModel();
		return is_array($_model) ? $_model : NULL;
	}

	public function compile(): ?array
	{
		return $this->compileAsArray();
	}
	public function getFactoryModel(): array
	{
		return [];
	}
	public function configureFactory($params = []): static
	{
		$this->__process_params($params);
		return $this;
	}

	public function getElementConfiguration(): ?array
	{
		return $this->FactoryElementConfiguration ?? $this->FactoryConfiguration;
	}

	public function getFactoryClasses(): string
	{
		$_classes = [];

		if (is_string($this->FactoryClass) && trim($this->FactoryClass) !== '') {
			$_classes = array_merge($_classes, preg_split('/\s+/', trim($this->FactoryClass)) ?: []);
		}

		if (is_array($this->FactoryElementUserClass)) {
			foreach ($this->FactoryElementUserClass as $_class) {
				if (is_string($_class) && trim($_class) !== '') {
					$_classes = array_merge($_classes, preg_split('/\s+/', trim($_class)) ?: []);
				}
			}
		} elseif (is_string($this->FactoryElementUserClass) && trim($this->FactoryElementUserClass) !== '') {
			$_classes = array_merge($_classes, preg_split('/\s+/', trim($this->FactoryElementUserClass)) ?: []);
		}

		if (is_string($this->FactoryElementSystemClass) && trim($this->FactoryElementSystemClass) !== '') {
			$_classes = array_merge($_classes, preg_split('/\s+/', trim($this->FactoryElementSystemClass)) ?: []);
		}

		$_classes = array_values(array_unique(array_filter($_classes, static function ($value) {
			return is_string($value) && trim($value) !== '';
		})));

		return implode(' ', $_classes);
	}

	public function getDefaultFactoryAttributePropertyCollection(): array
	{
		return [
			'id' => $this->getFactoryId(),
			'name' => $this->getFactoryName(),
			'class' => $this->getFactoryClasses(),
			'title' => $this->FactoryTitle,
			'style' => $this->FactoryStyle,
			'lang' => $this->FactoryLang,
			'dir' => $this->FactoryDir,
			'hidden' => $this->FactoryHidden,
			'tabindex' => $this->FactoryTabindex,
			'draggable' => $this->FactoryDraggable,
			'contenteditable' => $this->FactoryContenteditable,
			'spellcheck' => $this->FactorySpellcheck,
			'translate' => $this->FactoryTranslate,
			'role' => $this->FactoryRole,
			'aria-label' => $this->FactoryAriaLabel,
			'aria-labelledby' => $this->FactoryAriaLabelledby,
			'aria-describedby' => $this->FactoryAriaDescribedby,
			'configuration' => $this->getFactoryConfiguration(),
			'user' => $this->getFactoryUserClass(),
			'system' => $this->getFactorySystemClass(),
			'data' => $this->getFactoryDataParams(),
			'ext' => $this->getFactoryExtendedProperties()
		];
	}

	public function getFactoryConfiguration(): ?array
	{
		return $this->FactoryElementConfiguration;
	}

	public function getFactoryUserClass(): ?array
	{
		return $this->FactoryElementUserClass;
	}

	public function getFactorySystemClass(): ?string
	{
		return $this->FactoryElementSystemClass;
	}

	public function getFactoryDataParams(): ?array
	{
		return $this->FactoryElementDataParams;
	}

	public function getFactoryLang(): ?array
	{
		return $this->FactoryElementLanguageVars;
	}

	public function getFactoryExtendedProperties(): ?array
	{
		return $this->FactoryElementExtendedAttributes;
	}

	public function getLang($namespace)
	{
		return $this->FactoryElementLanguageVars[$namespace] ?? NULL;
	}

	public function getFactoryName(): ?string
	{
		return $this->FactoryName;
	}


	public function getFactoryId(): ?string
	{
		return $this->FactoryId;
	}

	public function compileAsHtmlString(): ?string
	{
		if (method_exists($this, 'getElementOpen') && method_exists($this, 'getElementContent') && method_exists($this, 'getElementClose')) {
			return $this->getElementOpen() . $this->getElementContent() . $this->getElementClose();
		}
		return NULL;
	}

	public function string(): ?string
	{
		return $this->compileAsHtmlString();
	}
}

