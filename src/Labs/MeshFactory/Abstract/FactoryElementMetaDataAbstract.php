<?php

namespace MvpLounge\MeshFactory\Abstract;

require_once __DIR__ . '/../Constants.php';

if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElement;

require_once __DIR__ . '/FactoryElementHtmlAbstract.php';
require_once __DIR__ . '/../Enum/FactoryElementAttribute.php';
require_once __DIR__ . '/../Enum/FactoryElement.php';

abstract class FactoryElementMetaDataAbstract extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::BASE,
        FactoryElement::LINK,
        FactoryElement::META,
        FactoryElement::STYLE,
        FactoryElement::TITLE
    ];

    protected array $AllowedFactoryElementAttributes = [
        FactoryElementAttribute::HREF,
        FactoryElementAttribute::REL,
        FactoryElementAttribute::HREFLANG,
        FactoryElementAttribute::MEDIA,
        FactoryElementAttribute::REFERRERPOLICY,
        FactoryElementAttribute::TYPE,
        FactoryElementAttribute::NAME,
        FactoryElementAttribute:: AS ,
        FactoryElementAttribute::INTEGRITY,
        FactoryElementAttribute::CROSSORIGIN
    ];

    protected ?string $FactoryElementMetaHref = NULL;
    protected ?string $FactoryElementMetaRel = NULL;
    protected ?string $FactoryElementMetaHreflang = NULL;
    protected ?string $FactoryElementMetaMedia = NULL;
    protected ?string $FactoryElementMetaReferrerpolicy = NULL;
    protected ?string $FactoryElementMetaType = NULL;
    protected ?string $FactoryElementMetaName = NULL;
    protected ?string $FactoryElementMetaAs = NULL;
    protected ?string $FactoryElementMetaIntegrity = NULL;
    protected ?string $FactoryElementMetaCrossorigin = NULL;

    protected function __process_href($params): void
    {
        if (array_key_exists('href', $params)) {
            $this->addHref($params['href']);
        }
    }

    protected function __process_rel($params): void
    {
        if (array_key_exists('rel', $params)) {
            $this->addRel($params['rel']);
        }
    }

    protected function __process_hreflang($params): void
    {
        if (array_key_exists('hreflang', $params)) {
            $this->addHreflang($params['hreflang']);
        }
    }

    protected function __process_media($params): void
    {
        if (array_key_exists('media', $params)) {
            $this->addMedia($params['media']);
        }
    }

    protected function __process_referrerpolicy($params): void
    {
        if (array_key_exists('referrerpolicy', $params)) {
            $this->addReferrerpolicy($params['referrerpolicy']);
        }
    }

    protected function __process_type($params): void
    {
        if (array_key_exists('type', $params)) {
            $this->addMetaType($params['type']);
        }
    }

    protected function __process_name($params): void
    {
        if (array_key_exists('name', $params)) {
            $this->addMetaName($params['name']);
        }
    }

    protected function __process_as($params): void
    {
        if (array_key_exists('as', $params)) {
            $this->addAs($params['as']);
        }
    }

    protected function __process_integrity($params): void
    {
        if (array_key_exists('integrity', $params)) {
            $this->addIntegrity($params['integrity']);
        }
    }

    protected function __process_crossorigin($params): void
    {
        if (array_key_exists('crossorigin', $params)) {
            $this->addCrossorigin($params['crossorigin']);
        }
    }

    public function addHref($href): static
    {
        $this->FactoryElementMetaHref = is_null($href) ? NULL : (string) $href;
        return $this;
    }

    public function addRel($rel): static
    {
        $this->FactoryElementMetaRel = is_null($rel) ? NULL : (string) $rel;
        return $this;
    }

    public function addHreflang($hreflang): static
    {
        $this->FactoryElementMetaHreflang = is_null($hreflang) ? NULL : (string) $hreflang;
        return $this;
    }

    public function addMedia($media): static
    {
        $this->FactoryElementMetaMedia = is_null($media) ? NULL : (string) $media;
        return $this;
    }

    public function addReferrerpolicy($referrerpolicy): static
    {
        $this->FactoryElementMetaReferrerpolicy = is_null($referrerpolicy) ? NULL : (string) $referrerpolicy;
        return $this;
    }

    public function addMetaType($type): static
    {
        $this->FactoryElementMetaType = is_null($type) ? NULL : (string) $type;
        return $this;
    }

    public function addType($type): static
    {
        return $this->addMetaType($type);
    }

    public function addMetaName($name): static
    {
        $this->FactoryElementMetaName = is_null($name) ? NULL : (string) $name;
        return $this;
    }

    public function addName($name): static
    {
        return $this->addMetaName($name);
    }

    public function addAs($as): static
    {
        $this->FactoryElementMetaAs = is_null($as) ? NULL : (string) $as;
        return $this;
    }

    public function addIntegrity($integrity): static
    {
        $this->FactoryElementMetaIntegrity = is_null($integrity) ? NULL : (string) $integrity;
        return $this;
    }

    public function addCrossorigin($crossorigin): static
    {
        $this->FactoryElementMetaCrossorigin = is_null($crossorigin) ? NULL : (string) $crossorigin;
        return $this;
    }

    public function getFactoryElementMetaHref(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::HREF->value, $allowed, TRUE) ? $this->FactoryElementMetaHref : NULL;
    }

    public function getFactoryElementMetaRel(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::REL->value, $allowed, TRUE) ? $this->FactoryElementMetaRel : NULL;
    }

    public function getFactoryElementMetaHreflang(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::HREFLANG->value, $allowed, TRUE) ? $this->FactoryElementMetaHreflang : NULL;
    }

    public function getFactoryElementMetaMedia(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::MEDIA->value, $allowed, TRUE) ? $this->FactoryElementMetaMedia : NULL;
    }

    public function getFactoryElementMetaReferrerpolicy(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::REFERRERPOLICY->value, $allowed, TRUE) ? $this->FactoryElementMetaReferrerpolicy : NULL;
    }

    public function getFactoryElementMetaType(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::TYPE->value, $allowed, TRUE) ? $this->FactoryElementMetaType : NULL;
    }

    public function getFactoryElementMetaName(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::NAME->value, $allowed, TRUE) ? $this->FactoryElementMetaName : NULL;
    }

    public function getFactoryElementMetaAs(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute:: AS ->value, $allowed, TRUE) ? $this->FactoryElementMetaAs : NULL;
    }

    public function getFactoryElementMetaIntegrity(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::INTEGRITY->value, $allowed, TRUE) ? $this->FactoryElementMetaIntegrity : NULL;
    }

    public function getFactoryElementMetaCrossorigin(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::CROSSORIGIN->value, $allowed, TRUE) ? $this->FactoryElementMetaCrossorigin : NULL;
    }

    public function getFactoryAttributePropertyCollection(): array
    {
        $_allowed = $this->getAllowedFactoryElementAttributes();

        return array_merge(
            $this->getDefaultFactoryAttributePropertyCollection(),
            [
                'href' => $this->getFactoryElementMetaHref($_allowed),
                'rel' => $this->getFactoryElementMetaRel($_allowed),
                'hreflang' => $this->getFactoryElementMetaHreflang($_allowed),
                'media' => $this->getFactoryElementMetaMedia($_allowed),
                'referrerpolicy' => $this->getFactoryElementMetaReferrerpolicy($_allowed),
                'type' => $this->getFactoryElementMetaType($_allowed),
                'name' => $this->getFactoryElementMetaName($_allowed),
                'as' => $this->getFactoryElementMetaAs($_allowed),
                'integrity' => $this->getFactoryElementMetaIntegrity($_allowed),
                'crossorigin' => $this->getFactoryElementMetaCrossorigin($_allowed)
            ]
        );
    }
}
