<?php

declare(strict_types=1);

use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;
use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;

if (!function_exists('mfAssert')) {
    function mfAssert(bool $condition, string $message): void
    {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }
}

if (!function_exists('mfBaseAttributeValues')) {
    function mfBaseAttributeValues(string $suffix): array
    {
        return [
            FactoryElementAttribute::ID->value => 'el_id_' . $suffix,
            FactoryElementAttribute::HTML_CLASS->value => 'el-class-' . $suffix,
            FactoryElementAttribute::TITLE->value => 'Element title ' . $suffix,
            FactoryElementAttribute::STYLE->value => 'display:block',
            FactoryElementAttribute::LANG->value => 'en',
            FactoryElementAttribute::DIR->value => 'ltr',
            FactoryElementAttribute::HIDDEN->value => 'hidden',
            FactoryElementAttribute::TABINDEX->value => 7,
            FactoryElementAttribute::DRAGGABLE->value => 'false',
            FactoryElementAttribute::CONTENTEDITABLE->value => 'false',
            FactoryElementAttribute::SPELLCHECK->value => 'false',
            FactoryElementAttribute::TRANSLATE->value => 'no',
            FactoryElementAttribute::ROLE->value => 'presentation',
            FactoryElementAttribute::ARIA_LABEL->value => 'aria-label-' . $suffix,
            FactoryElementAttribute::ARIA_LABELLEDBY->value => 'aria-labelledby-' . $suffix,
            FactoryElementAttribute::ARIA_DESCRIBEDBY->value => 'aria-describedby-' . $suffix
        ];
    }
}

if (!function_exists('mfAttributeSampleValue')) {
    function mfAttributeSampleValue(string $attribute, string $suffix)
    {
        switch ($attribute) {
            case FactoryElementAttribute::HREF->value:
                return 'https://example.test/' . $suffix;
            case FactoryElementAttribute::TARGET->value:
                return FactoryElementWindowTarget::SELF->value;
            case FactoryElementAttribute::REL->value:
                return 'noopener noreferrer';
            case FactoryElementAttribute::ACTION->value:
                return '/submit/' . $suffix;
            case FactoryElementAttribute::METHOD->value:
                return 'post';
            case FactoryElementAttribute::ENCTYPE->value:
                return 'multipart/form-data';
            case FactoryElementAttribute::NOVALIDATE->value:
                return 'novalidate';
            case FactoryElementAttribute::AUTOCOMPLETE->value:
                return 'on';
            case FactoryElementAttribute::PLACEHOLDER->value:
                return 'placeholder_' . $suffix;
            case FactoryElementAttribute::TYPE->value:
                return 'text';
            case FactoryElementAttribute::VALUE->value:
                return 'value_' . $suffix;
            case FactoryElementAttribute::ROWS->value:
                return 3;
            case FactoryElementAttribute::COLS->value:
                return 12;
            case FactoryElementAttribute::COLSPAN->value:
                return 2;
            case FactoryElementAttribute::ROWSPAN->value:
                return 2;
            case FactoryElementAttribute::SCOPE->value:
                return 'col';
            case FactoryElementAttribute::HEADERS->value:
                return 'h1 h2';
            case FactoryElementAttribute::ABBR->value:
                return 'abbr_' . $suffix;
            case FactoryElementAttribute::SELECTED->value:
                return true;
            case FactoryElementAttribute::CHECKED->value:
                return true;
            case FactoryElementAttribute::CELLSPACING->value:
                return 0;
            case FactoryElementAttribute::CELLPADDING->value:
                return 1;
            case FactoryElementAttribute::BORDER->value:
                return 1;
            case FactoryElementAttribute::ACCESS->value:
                return true;
            case FactoryElementAttribute::ALT->value:
                return 'alt_' . $suffix;
            case FactoryElementAttribute::SRC->value:
                return '/assets/' . $suffix . '.png';
            case FactoryElementAttribute::FOR ->value:
                return 'field_' . $suffix;
            case FactoryElementAttribute::HREFLANG->value:
                return 'en-US';
            case FactoryElementAttribute::MEDIA->value:
                return 'screen';
            case FactoryElementAttribute::PING->value:
                return 'https://example.test/ping/' . $suffix;
            case FactoryElementAttribute::REFERRERPOLICY->value:
                return 'no-referrer';
            case FactoryElementAttribute::NAME->value:
                return 'name_' . $suffix;
            case FactoryElementAttribute::DATA->value:
                return [
                    'qa' => $suffix,
                    'component' => 'meshfactory'
                ];
            case FactoryElementAttribute::CONTENT->value:
                return 'params-content-' . $suffix;
            case FactoryElementAttribute::SRCSET->value:
                return '/assets/' . $suffix . '-1x.png 1x, /assets/' . $suffix . '-2x.png 2x';
            case FactoryElementAttribute::SIZES->value:
                return '(max-width: 600px) 100vw, 50vw';
            case FactoryElementAttribute::CROSSORIGIN->value:
                return 'anonymous';
            case FactoryElementAttribute::INTEGRITY->value:
                return 'sha384-testhash-' . $suffix;
            case FactoryElementAttribute:: AS ->value:
                return 'script';
            case FactoryElementAttribute::FETCHPRIORITY->value:
                return 'high';
            case FactoryElementAttribute::PRELOAD->value:
                return 'metadata';
            case FactoryElementAttribute::POSTER->value:
                return '/assets/' . $suffix . '-poster.png';
            case FactoryElementAttribute::AUTOPLAY->value:
            case FactoryElementAttribute::CONTROLS->value:
            case FactoryElementAttribute::LOOP->value:
            case FactoryElementAttribute::MUTED->value:
            case FactoryElementAttribute::DISABLED->value:
            case FactoryElementAttribute::DEFAULT_STATE->value:
                return true;
            case FactoryElementAttribute::FORM->value:
                return 'form_' . $suffix;
            case FactoryElementAttribute::MIN->value:
                return '0';
            case FactoryElementAttribute::MAX->value:
                return '100';
            case FactoryElementAttribute::STEP->value:
                return '5';
            case FactoryElementAttribute::HIGH->value:
                return '80';
            case FactoryElementAttribute::LOW->value:
                return '20';
            case FactoryElementAttribute::OPTIMUM->value:
                return '50';
            case FactoryElementAttribute::KIND->value:
                return 'captions';
            case FactoryElementAttribute::SRCLANG->value:
                return 'en';
            default:
                return $attribute . '_' . $suffix;
        }
    }
}

if (!function_exists('mfProcessableAttributeKeys')) {
    function mfProcessableAttributeKeys(object $factory): array
    {
        $reflection = new ReflectionClass($factory);
        $attributes = [];

        foreach ($reflection->getMethods() as $method) {
            $name = $method->getName();
            if (!preg_match('/^__process_(.+)$/', $name, $matches)) {
                continue;
            }

            $attribute = strtolower(trim((string) $matches[1]));
            if ($attribute === '') {
                continue;
            }

            $attributes[$attribute] = true;
        }

        return array_keys($attributes);
    }
}

if (!function_exists('mfIsUnsafeGeneratedAttribute')) {
    function mfIsUnsafeGeneratedAttribute(string $attribute): bool
    {
        static $unsafe = [
        'configuration',
        'element',
        'ext',
        'system',
        'user',
        'params'
        ];

        return in_array($attribute, $unsafe, true);
    }
}

if (!function_exists('mfAllowedAttributeValues')) {
    function mfAllowedAttributeValues(object $factory, string $suffix): array
    {
        $allowed = [];
        if (method_exists($factory, 'getAllowedFactoryElementAttributes')) {
            $allowed = $factory->getAllowedFactoryElementAttributes();
        }

        if (!is_array($allowed)) {
            return [];
        }

        $attributeKeys = [];
        foreach ($allowed as $attribute) {
            if (!is_string($attribute)) {
                continue;
            }

            $_attribute = strtolower(trim($attribute));
            if ($_attribute === '') {
                continue;
            }

            $attributeKeys[$_attribute] = true;
        }

        foreach (mfProcessableAttributeKeys($factory) as $_attribute) {
            $attributeKeys[$_attribute] = true;
        }

        $values = [];
        foreach (array_keys($attributeKeys) as $_attribute) {
            if (mfIsUnsafeGeneratedAttribute($_attribute)) {
                continue;
            }
            $values[$_attribute] = mfAttributeSampleValue($_attribute, $suffix);
        }

        return $values;
    }
}

if (!function_exists('mfBuildScopedParams')) {
    function mfBuildScopedParams(object $factory, string $suffix): array
    {
        $params = [];
        $processable = mfProcessableAttributeKeys($factory);

        foreach (mfBaseAttributeValues($suffix) as $attribute => $value) {
            $params[$attribute] = $value;
        }

        foreach (mfAllowedAttributeValues($factory, $suffix) as $attribute => $value) {
            $params[$attribute] = $value;
        }

        echo '-- Discoverable processable params: ' . get_class($factory) . ' --' . PHP_EOL;
        print_r($processable);
        echo '-- End discoverable processable params --' . PHP_EOL;

        echo '-- Params payload: ' . get_class($factory) . ' --' . PHP_EOL;
        print_r($params);
        echo '-- End params payload --' . PHP_EOL;

        return $params;
    }
}

if (!function_exists('mfCollectOutputs')) {
    function mfCollectOutputs(object $factory): array
    {
        $arrayData = method_exists($factory, 'compileAsArray') ? $factory->compileAsArray() : null;
        $compileData = method_exists($factory, 'compile') ? $factory->compile() : null;
        $jsonData = method_exists($factory, 'compileAsJson') ? $factory->compileAsJson() : null;
        $htmlData = method_exists($factory, 'compileAsHtmlString') ? $factory->compileAsHtmlString() : null;
        $stringData = method_exists($factory, 'string') ? $factory->string() : null;

        return [
            'arrayData' => is_array($arrayData) ? $arrayData : null,
            'compileData' => is_array($compileData) ? $compileData : null,
            'jsonData' => is_string($jsonData) ? $jsonData : null,
            'htmlData' => is_string($htmlData) ? $htmlData : null,
            'stringData' => is_string($stringData) ? $stringData : null
        ];
    }
}

if (!function_exists('mfCollectStrings')) {
    function mfCollectStrings($value): array
    {
        if (is_string($value)) {
            return [$value];
        }

        if (!is_array($value)) {
            return [];
        }

        $strings = [];
        foreach ($value as $item) {
            $strings = array_merge($strings, mfCollectStrings($item));
        }

        return $strings;
    }
}

if (!function_exists('mfExtractMarkup')) {
    function mfExtractMarkup(array $outputs): string
    {
        foreach (['arrayData', 'compileData'] as $key) {
            if (!is_array($outputs[$key])) {
                continue;
            }

            foreach (mfCollectStrings($outputs[$key]) as $stringValue) {
                if (str_contains($stringValue, '<')) {
                    return $stringValue;
                }
            }
        }

        foreach (['jsonData', 'htmlData', 'stringData'] as $key) {
            if (is_string($outputs[$key]) && str_contains($outputs[$key], '<')) {
                return $outputs[$key];
            }
        }

        return '';
    }
}

if (!function_exists('mfAssertRenderableOutputs')) {
    function mfAssertRenderableOutputs(object $factory, string $className, ?array $params = null): void
    {
        if (is_array($params)) {
            echo '-- Params payload: ' . $className . ' --' . PHP_EOL;
            print_r($params);
            echo '-- End params payload --' . PHP_EOL;
        }

        $outputs = mfCollectOutputs($factory);
        mfPrintRenderableOutputs($className, $outputs);
        mfAssert(is_array($outputs['arrayData']), $className . ' compileAsArray() must return array.');
        mfAssert(is_array($outputs['compileData']), $className . ' compile() must return array.');

        $markup = mfExtractMarkup($outputs);
        mfAssert($markup !== '', $className . ' did not produce renderable markup from compile/render methods.');
    }
}

if (!function_exists('mfPrintRenderableOutputs')) {
    function mfPrintRenderableOutputs(string $className, array $outputs): void
    {
        echo '-- Render outputs: ' . $className . ' --' . PHP_EOL;

        $labels = [
            'arrayData' => 'compileAsArray()',
            'compileData' => 'compile()',
            'jsonData' => 'compileAsJson()',
            'htmlData' => 'compileAsHtmlString()',
            'stringData' => 'string()'
        ];

        foreach ($labels as $key => $label) {
            $value = $outputs[$key] ?? null;

            echo $label . ':' . PHP_EOL;

            if (is_null($value)) {
                echo "NULL" . PHP_EOL;
            } elseif (is_array($value)) {
                print_r($value);
            } else {
                var_dump($value);
            }
        }

        echo '-- End render outputs --' . PHP_EOL;
    }
}
