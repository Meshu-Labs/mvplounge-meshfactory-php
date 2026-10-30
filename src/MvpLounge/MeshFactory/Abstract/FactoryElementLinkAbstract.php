<?php

namespace MvpLounge\MeshFactory\Abstract;



require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
	throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;

require_once __DIR__ . '/FactoryElementAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElementWindowTarget.php';




/**
 * Anchor element support for hyperlink-specific attributes.
 *
 * MDN element reference:
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a
 */
class FactoryElementLinkAbstract extends FactoryElementAbstract
{

	protected array $AllowedFactoryElements = [
		FactoryElement::ANCHOR
	];
	protected array $AllowedFactoryElementAttributes = [
		FactoryElementAttribute::HREF,
		FactoryElementAttribute::TARGET,
		FactoryElementAttribute::REL,
		FactoryElementAttribute::HREFLANG,
		FactoryElementAttribute::MEDIA,
		FactoryElementAttribute::PING,
		FactoryElementAttribute::REFERRERPOLICY,
		FactoryElementAttribute::TYPE
	];

	protected ?FactoryElement $FactoryElement = FactoryElement::ANCHOR;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#hreflang */
	protected ?string $FactoryElementLinkHreflang = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#media */
	protected ?string $FactoryElementLinkMedia = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#ping */
	protected ?string $FactoryElementLinkPing = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#referrerpolicy */
	protected ?string $FactoryElementLinkReferrerPolicy = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#type */
	protected ?string $FactoryElementLinkType = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#href */
	protected ?string $FactoryElementPath = NULL;
	/** @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a#rel */
	protected ?string $FactoryElementRel = NULL;
	protected ?string $FactoryElementSystemClass = 'generic-a';
	protected ?string $FactoryElementTarget = NULL;
	protected ?string $FactoryElementTitle = NULL;

	public function __construct($params = [])
	{
		parent::__construct($params);
	}

	protected function __process_hreflang($params): void
	{
		if (isset($params['hreflang']) && is_string($params['hreflang'])) {
			$this->addHrefLang($params['hreflang']);
		}
	}

	protected function __process_media($params): void
	{
		if (isset($params['media']) && is_string($params['media'])) {
			$this->addMedia($params['media']);
		}
	}

	protected function __process_ping($params): void
	{
		if (isset($params['ping']) && is_string($params['ping'])) {
			$this->addPing($params['ping']);
		}
	}

	protected function __process_ring($params): void
	{
		if (isset($params['ring']) && is_string($params['ring'])) {
			$this->addPing($params['ring']);
		}
	}

	protected function __process_referrerpolicy($params): void
	{
		if (isset($params['referrerpolicy']) && is_string($params['referrerpolicy'])) {
			$this->addReferrerPolicy($params['referrerpolicy']);
		}
	}

	protected function __process_referrerrolicy($params): void
	{
		if (isset($params['referrerrolicy']) && is_string($params['referrerrolicy'])) {
			$this->addReferrerPolicy($params['referrerrolicy']);
		}
	}

	protected function __process_type($params): void
	{
		if (isset($params['type']) && is_string($params['type'])) {
			$this->addLinkType($params['type']);
		}
	}

	protected function __process_href($params): void
	{

		if (isset($params['href']) && is_string($params['href'])) {
			$this->addHref($params['href']);
		}
	}

	public function addHref($href): static
	{
		$this->FactoryElementPath = $href;
		return $this;
	}

	protected function __process_rel($params): void
	{

		if (isset($params['rel']) && is_string($params['rel'])) {
			$this->addRel($params['rel']);
		}
	}

	public function addRel($rel): static
	{
		$this->FactoryElementRel = $rel;
		return $this;
	}

	protected function __process_title($params): void
	{

		if (isset($params['title']) && is_string($params['title'])) {
			$this->addTitle($params['title']);
		}
	}

	public function addTitle($title): static
	{
		$this->FactoryElementTitle = $title;
		return $this;
	}

	protected function __process_target($params): void
	{

		if (isset($params['target']) && is_string($params['target'])) {

			switch (strtolower($params['target'])) {
				case 'self':
				case FactoryElementWindowTarget::SELF->value:
					$this->addTarget(FactoryElementWindowTarget::SELF->value);
					break;
				case 'blank':
				case FactoryElementWindowTarget::BLANK->value:
					$this->addTarget(FactoryElementWindowTarget::BLANK->value);
					break;
				case 'parent':
				case FactoryElementWindowTarget::PARENT->value:
					$this->addTarget(FactoryElementWindowTarget::PARENT->value);
					break;
				case 'top':
				case FactoryElementWindowTarget::TOP->value:
					$this->addTarget(FactoryElementWindowTarget::TOP->value);
					break;
			}
		}
	}

	public function addTarget($target): static
	{
		$this->FactoryElementTarget = $target;
		return $this;
	}

	public function addHrefLang($hreflang): static
	{
		$this->FactoryElementLinkHreflang = is_null($hreflang) ? NULL : (string) $hreflang;
		return $this;
	}

	public function addMedia($media): static
	{
		$this->FactoryElementLinkMedia = is_null($media) ? NULL : (string) $media;
		return $this;
	}

	public function addPing($ping): static
	{
		$this->FactoryElementLinkPing = is_null($ping) ? NULL : (string) $ping;
		return $this;
	}

	public function addReferrerPolicy($referrerPolicy): static
	{
		$this->FactoryElementLinkReferrerPolicy = is_null($referrerPolicy) ? NULL : (string) $referrerPolicy;
		return $this;
	}

	public function addLinkType($type): static
	{
		$this->FactoryElementLinkType = is_null($type) ? NULL : (string) $type;
		return $this;
	}

	public function addType($type): static
	{
		return $this->addLinkType($type);
	}

	public function getFactoryElementLinkHref(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::HREF->value, $allowed, TRUE) ? $this->FactoryElementPath : NULL;
	}

	public function getFactoryElementLinkTarget(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::TARGET->value, $allowed, TRUE) ? $this->FactoryElementTarget : NULL;
	}

	public function getFactoryElementLinkRel(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::REL->value, $allowed, TRUE) ? $this->FactoryElementRel : NULL;
	}

	public function getFactoryElementLinkHreflang(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::HREFLANG->value, $allowed, TRUE) ? $this->FactoryElementLinkHreflang : NULL;
	}

	public function getFactoryElementLinkMedia(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::MEDIA->value, $allowed, TRUE) ? $this->FactoryElementLinkMedia : NULL;
	}

	public function getFactoryElementLinkPing(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::PING->value, $allowed, TRUE) ? $this->FactoryElementLinkPing : NULL;
	}

	public function getFactoryElementLinkReferrerPolicy(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::REFERRERPOLICY->value, $allowed, TRUE) ? $this->FactoryElementLinkReferrerPolicy : NULL;
	}

	public function getFactoryElementLinkType(array $allowed): ?string
	{
		return in_array(FactoryElementAttribute::TYPE->value, $allowed, TRUE) ? $this->FactoryElementLinkType : NULL;
	}

	public function getFactoryAttributePropertyCollection(): array
	{
		$_allowed = $this->getAllowedFactoryElementAttributes();

		return array_merge(
			$this->getDefaultFactoryAttributePropertyCollection(),
			[
				'title' => $this->FactoryElementTitle ?? $this->FactoryTitle,
				'href' => $this->getFactoryElementLinkHref($_allowed),
				'target' => $this->getFactoryElementLinkTarget($_allowed),
				'rel' => $this->getFactoryElementLinkRel($_allowed),
				'hreflang' => $this->getFactoryElementLinkHreflang($_allowed),
				'media' => $this->getFactoryElementLinkMedia($_allowed),
				'ping' => $this->getFactoryElementLinkPing($_allowed),
				'referrerpolicy' => $this->getFactoryElementLinkReferrerPolicy($_allowed),
				'type' => $this->getFactoryElementLinkType($_allowed)
			]
		);
	}

}

