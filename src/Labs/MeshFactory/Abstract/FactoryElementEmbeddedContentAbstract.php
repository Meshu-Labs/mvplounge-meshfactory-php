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

abstract class FactoryElementEmbeddedContentAbstract extends FactoryElementHtmlAbstract
{
    protected array $AllowedFactoryElements = [
        FactoryElement::EMBED,
        FactoryElement::FENCEDFRAME,
        FactoryElement::IFRAME,
        FactoryElement::OBJECT,
        FactoryElement::PARAM,
        FactoryElement::PICTURE,
        FactoryElement::SOURCE
    ];

    protected array $AllowedFactoryElementAttributes = [
        FactoryElementAttribute::SRC,
        FactoryElementAttribute::TYPE,
        FactoryElementAttribute::NAME,
        FactoryElementAttribute::LOADING,
        FactoryElementAttribute::DECODING,
        FactoryElementAttribute::FETCHPRIORITY
    ];

    protected ?string $FactoryElementEmbeddedSrc = NULL;
    protected ?string $FactoryElementEmbeddedType = NULL;
    protected ?string $FactoryElementEmbeddedName = NULL;
    protected ?string $FactoryElementEmbeddedLoading = NULL;
    protected ?string $FactoryElementEmbeddedDecoding = NULL;
    protected ?string $FactoryElementEmbeddedFetchpriority = NULL;

    protected function __process_src($params): void
    {
        if (array_key_exists('src', $params)) {
            $this->addSrc($params['src']);
        }
    }

    protected function __process_type($params): void
    {
        if (array_key_exists('type', $params)) {
            $this->addEmbeddedType($params['type']);
        }
    }

    protected function __process_name($params): void
    {
        if (array_key_exists('name', $params)) {
            $this->addEmbeddedName($params['name']);
        }
    }

    protected function __process_loading($params): void
    {
        if (array_key_exists('loading', $params)) {
            $this->addLoading($params['loading']);
        }
    }

    protected function __process_decoding($params): void
    {
        if (array_key_exists('decoding', $params)) {
            $this->addDecoding($params['decoding']);
        }
    }

    protected function __process_fetchpriority($params): void
    {
        if (array_key_exists('fetchpriority', $params)) {
            $this->addFetchPriority($params['fetchpriority']);
        }
    }

    public function addSrc($src): static
    {
        $this->FactoryElementEmbeddedSrc = is_null($src) ? NULL : (string) $src;
        return $this;
    }

    public function addEmbeddedType($type): static
    {
        $this->FactoryElementEmbeddedType = is_null($type) ? NULL : (string) $type;
        return $this;
    }

    public function addType($type): static
    {
        return $this->addEmbeddedType($type);
    }

    public function addEmbeddedName($name): static
    {
        $this->FactoryElementEmbeddedName = is_null($name) ? NULL : (string) $name;
        return $this;
    }

    public function addName($name): static
    {
        return $this->addEmbeddedName($name);
    }

    public function addLoading($loading): static
    {
        $this->FactoryElementEmbeddedLoading = is_null($loading) ? NULL : (string) $loading;
        return $this;
    }

    public function addDecoding($decoding): static
    {
        $this->FactoryElementEmbeddedDecoding = is_null($decoding) ? NULL : (string) $decoding;
        return $this;
    }

    public function addFetchPriority($fetchPriority): static
    {
        $this->FactoryElementEmbeddedFetchpriority = is_null($fetchPriority) ? NULL : (string) $fetchPriority;
        return $this;
    }

    public function getFactoryElementEmbeddedSrc(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::SRC->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedSrc : NULL;
    }

    public function getFactoryElementEmbeddedType(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::TYPE->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedType : NULL;
    }

    public function getFactoryElementEmbeddedName(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::NAME->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedName : NULL;
    }

    public function getFactoryElementEmbeddedLoading(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::LOADING->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedLoading : NULL;
    }

    public function getFactoryElementEmbeddedDecoding(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::DECODING->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedDecoding : NULL;
    }

    public function getFactoryElementEmbeddedFetchpriority(array $allowed): ?string
    {
        return in_array(FactoryElementAttribute::FETCHPRIORITY->value, $allowed, TRUE) ? $this->FactoryElementEmbeddedFetchpriority : NULL;
    }

    public function getFactoryAttributePropertyCollection(): array
    {
        $_allowed = $this->getAllowedFactoryElementAttributes();

        return array_merge(
            $this->getDefaultFactoryAttributePropertyCollection(),
            [
                'src' => $this->getFactoryElementEmbeddedSrc($_allowed),
                'type' => $this->getFactoryElementEmbeddedType($_allowed),
                'name' => $this->getFactoryElementEmbeddedName($_allowed),
                'loading' => $this->getFactoryElementEmbeddedLoading($_allowed),
                'decoding' => $this->getFactoryElementEmbeddedDecoding($_allowed),
                'fetchpriority' => $this->getFactoryElementEmbeddedFetchpriority($_allowed)
            ]
        );
    }
}
