<?php

declare(strict_types=1);

/**
 * Regenerates docs/architecture/AX-element-factory-inventory.md from the live code.
 *
 * Usage (from repo root):
 *   php src/Sandbox/MeshFactory/_shared/generate-element-inventory.php --write
 *   php src/Sandbox/MeshFactory/_shared/generate-element-inventory.php        (prints to stdout)
 *
 * Source of truth: reflection over src/Labs/MeshFactory/Element plus the FactoryElement and
 * FactoryElementAttribute enums. Spec attribute lists below are curated from the WHATWG HTML
 * Standard / MDN and are the only hand-maintained data in this file.
 */

require_once __DIR__ . '/../bootstrap.php';

use MvpLounge\MeshFactory\Enum\FactoryElement;
use MvpLounge\MeshFactory\Enum\FactoryElementAttribute;

$repoRoot = dirname(__DIR__, 4);
$libRoot = $repoRoot . '/src/Labs/MeshFactory';
$sandboxRoot = $repoRoot . '/src/Sandbox/MeshFactory';

/** Non-global attributes defined for each element by the HTML Standard (curated, MDN-aligned). */
$specAttributes = [
    'a' => ['href', 'target', 'download', 'ping', 'rel', 'hreflang', 'type', 'referrerpolicy'],
    'area' => ['alt', 'coords', 'download', 'href', 'hreflang', 'ping', 'referrerpolicy', 'rel', 'shape', 'target'],
    'audio' => ['autoplay', 'controls', 'crossorigin', 'loop', 'muted', 'preload', 'src'],
    'video' => ['autoplay', 'controls', 'crossorigin', 'height', 'loop', 'muted', 'poster', 'preload', 'src', 'width'],
    'img' => ['alt', 'crossorigin', 'decoding', 'fetchpriority', 'height', 'ismap', 'loading', 'referrerpolicy', 'sizes', 'src', 'srcset', 'usemap', 'width'],
    'iframe' => ['allow', 'height', 'loading', 'name', 'referrerpolicy', 'sandbox', 'src', 'srcdoc', 'width'],
    'embed' => ['height', 'src', 'type', 'width'],
    'object' => ['data', 'form', 'height', 'name', 'type', 'usemap', 'width'],
    'param' => ['name', 'value'],
    'source' => ['type', 'src', 'srcset', 'sizes', 'media', 'height', 'width'],
    'track' => ['default', 'kind', 'label', 'src', 'srclang'],
    'canvas' => ['height', 'width'],
    'script' => ['async', 'blocking', 'crossorigin', 'defer', 'fetchpriority', 'integrity', 'nomodule', 'referrerpolicy', 'src', 'type'],
    'link' => ['as', 'blocking', 'crossorigin', 'fetchpriority', 'href', 'hreflang', 'integrity', 'media', 'referrerpolicy', 'rel', 'sizes', 'type'],
    'meta' => ['charset', 'content', 'http-equiv', 'media', 'name'],
    'base' => ['href', 'target'],
    'style' => ['media', 'blocking'],
    'button' => ['disabled', 'form', 'name', 'type', 'value'],
    'input' => ['accept', 'autocomplete', 'checked', 'disabled', 'form', 'list', 'max', 'maxlength', 'min', 'minlength', 'multiple', 'name', 'pattern', 'placeholder', 'readonly', 'required', 'size', 'step', 'type', 'value'],
    'label' => ['for'],
    'select' => ['autocomplete', 'disabled', 'form', 'multiple', 'name', 'required', 'size'],
    'option' => ['disabled', 'label', 'selected', 'value'],
    'optgroup' => ['disabled', 'label'],
    'textarea' => ['autocomplete', 'cols', 'dirname', 'disabled', 'form', 'maxlength', 'minlength', 'name', 'placeholder', 'readonly', 'required', 'rows', 'wrap'],
    'fieldset' => ['disabled', 'form', 'name'],
    'meter' => ['high', 'low', 'max', 'min', 'optimum', 'value'],
    'progress' => ['max', 'value'],
    'output' => ['for', 'form', 'name'],
    'form' => ['action', 'autocomplete', 'enctype', 'method', 'name', 'novalidate', 'rel', 'target'],
    'blockquote' => ['cite'],
    'q' => ['cite'],
    'del' => ['cite', 'datetime'],
    'ins' => ['cite', 'datetime'],
    'time' => ['datetime'],
    'data' => ['value'],
    'ol' => ['reversed', 'start', 'type'],
    'li' => ['value'],
    'details' => ['open', 'name'],
    'dialog' => ['open'],
    'col' => ['span'],
    'colgroup' => ['span'],
    'td' => ['colspan', 'headers', 'rowspan'],
    'th' => ['abbr', 'colspan', 'headers', 'rowspan', 'scope'],
    'map' => ['name'],
    'slot' => ['name'],
    'html' => ['xmlns'],
];

/** Elements whose HTML5 form is not void but which render as void-like; used for the void check. */
$voidElements = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];

/** Mesh UI (TypeScript) counterpart per element, curated from src/library/Foundation. */
$tsByElement = [
    'p' => 'Part/Copy: UI_GenericParagraph',
    'h1' => 'Part/Copy: Copy.Header', 'h2' => 'Part/Copy: Copy.Header', 'h3' => 'Part/Copy: Copy.Header',
    'h4' => 'Part/Copy: Copy.Header', 'h5' => 'Part/Copy: Copy.Header', 'h6' => 'Part/Copy: Copy.Header',
    'ul' => 'Part/Copy: Copy.Lists', 'ol' => 'Part/Copy: Copy.Lists', 'li' => 'Part/Copy: Copy.Lists',
    'img' => 'Part/Copy: Copy.Images, Part/Logos',
    'a' => 'Part/Buttons: Button.Generic',
    'form' => 'Module/Form: UI_FormModule',
    'input' => 'Part/Field: Field.Input',
    'select' => 'Part/Field: Field.Select', 'option' => 'Part/Field: Field.Select',
    'textarea' => 'Part/Field: Field.Textarea',
    'fieldset' => 'Part/Field: Fieldset.Collection',
    'label' => 'Helper: UI_WrappedFieldLabel',
    'table' => 'Module/Table (style+script only, no TSX)', 'thead' => 'Module/Table (style+script only, no TSX)',
    'tbody' => 'Module/Table (style+script only, no TSX)', 'tfoot' => 'Module/Table (style+script only, no TSX)',
    'tr' => 'Module/Table (style+script only, no TSX)', 'th' => 'Module/Table (style+script only, no TSX)',
    'td' => 'Module/Table (style+script only, no TSX)',
    'nav' => 'Module/Navigation',
    'aside' => 'Module/Accordion',
    'section' => 'Module/Form (wrapper)',
];
$tsByClass = [
    'InputText' => 'Part/Field: Field.Input (text)',
    'InputEmailer' => 'Part/Field: Field.Input (email)',
    'InputPassword' => 'Part/Field: Field.Input (password)',
    'InputHidden' => 'Part/Field: Field.Input (hidden)',
    'InputRadio' => 'Part/Field: Field.Input (radio group)',
    'FormButton' => 'Part/Field: Field.Input (button/submit/reset)',
    'InputButton' => 'Part/Buttons: Button.Generic',
];

/** Concrete classes imported directly by APP-EELC (libraries/resource/ui, designer, Trait). */
$eelcDirect = [
    'Img', 'Aside', 'Header', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'Hl', 'Figure', 'Main', 'P', 'Content', 'Anchor',
    'TableBody', 'DataTableBody', 'TableRow', 'TableRowBody', 'TableCell', 'TableHeader',
    'FormPost', 'FormAjax', 'InputText', 'InputEmailer', 'InputPassword', 'InputHidden', 'InputRadio', 'SelectOption', 'FormButton'
];

$scan = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($libRoot . '/Element', FilesystemIterator::SKIP_DOTS));
$classes = [];
foreach ($scan as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php' || $file->getFilename() === 'index.php') {
        continue;
    }
    $source = (string) file_get_contents($file->getPathname());
    if (!preg_match('/^\s*namespace\s+([^;]+);/m', $source, $ns) || !preg_match('/^\s*(?:abstract\s+)?class\s+(\w+)/m', $source, $cl)) {
        continue;
    }
    require_once $file->getPathname();
    $fqcn = trim($ns[1]) . '\\' . $cl[1];
    $reflection = new ReflectionClass($fqcn);
    if ($reflection->isAbstract()) {
        continue;
    }
    $instance = $reflection->newInstance();
    $elementProperty = new ReflectionProperty($instance, 'FactoryElement');
    $element = $elementProperty->getValue($instance);
    $own = [];
    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->getDeclaringClass()->getName() === $fqcn && $method->getName() !== '__construct') {
            $own[] = $method->getName();
        }
    }
    $allowed = $instance->getAllowedFactoryElementAttributes();
    $parent = $reflection->getParentClass();
    $classes[] = [
        'class' => $cl[1],
        'fqcn' => $fqcn,
        'dir' => basename(dirname($file->getPathname())),
        'element' => $element instanceof FactoryElement ? $element->value : null,
        'parent' => $parent ? $parent->getShortName() : '-',
        'allowed' => $allowed,
        'own' => $own,
        'void' => $element instanceof FactoryElement && in_array($element->value, $voidElements, true) && str_contains((string) $instance->compileAsHtmlString(), '</' . $element->value . '>'),
    ];
}

$enumAttributes = array_map(static fn(FactoryElementAttribute $a): string => $a->value, FactoryElementAttribute::cases());

$byElement = [];
foreach ($classes as $row) {
    if ($row['element'] !== null) {
        $byElement[$row['element']][] = $row;
    }
}

$domainSuites = [];
foreach (['Field' => 'field', 'Form' => 'form', 'Table' => 'table'] as $domain => $slug) {
    foreach (['Generic' => 'g', 'Factory' => 'f', 'Params' => 'p'] as $flavor => $letter) {
        $path = sprintf('%s/%s/%s/%s-elements-sandbox.php', $sandboxRoot, $domain, $flavor, $slug);
        if (is_file($path)) {
            $domainSuites[$letter][] = (string) file_get_contents($path);
        }
    }
}
$tests = static function (array $row) use ($sandboxRoot, $domainSuites): string {
    $letters = '';
    foreach (['Generic' => 'G', 'Factory' => 'F', 'Params' => 'P'] as $flavor => $letter) {
        if (is_file(sprintf('%s/%s/%s/%s-sandbox.php', $sandboxRoot, $row['dir'], $flavor, $row['class']))) {
            $letters .= $letter;
        }
    }
    if ($letters !== '') {
        return $letters;
    }
    foreach (['g', 'f', 'p'] as $letter) {
        foreach ($domainSuites[$letter] ?? [] as $suite) {
            if (preg_match('~\\\\' . preg_quote($row['class'], '~') . '\b~', $suite) === 1) {
                $letters .= $letter;
                break;
            }
        }
    }
    return $letters === '' ? '-' : $letters;
};

$tierOf = static function (array $row): string {
    if ($row['own'] !== []) {
        return 'Behavioral';
    }
    return $row['allowed'] === [] ? 'Stub' : 'Family';
};

$rows = [];
$tierCount = ['Unbound' => 0, 'Stub' => 0, 'Family' => 0, 'Behavioral' => 0];
$domainCount = [];
$gapTotal = 0;
$extraTotal = 0;
$voidBugs = [];

foreach (FactoryElement::cases() as $case) {
    $element = $case->value;
    $spec = $specAttributes[$element] ?? [];
    $bound = $byElement[$element] ?? [];

    if ($bound === []) {
        $tierCount['Unbound']++;
        $rows[] = sprintf('| `%s` | - | - | - | Unbound | %s | - | - | - | - |', $element, $spec === [] ? '-' : implode(', ', array_map(static fn($a) => '`' . $a . '`' . (in_array($a, $enumAttributes, true) ? '' : '*'), $spec)));
        continue;
    }

    foreach ($bound as $row) {
        $tier = $tierOf($row);
        $tierCount[$tier]++;
        $domainCount[$row['dir']] = ($domainCount[$row['dir']] ?? 0) + 1;
        $missing = array_values(array_diff($spec, $row['allowed']));
        $extra = array_values(array_diff($row['allowed'], $spec, ['access']));
        if ($element === 'input') {
            $missing = [];
            $extra = [];
        }
        $gapTotal += count($missing);
        $extraTotal += $spec === [] ? 0 : count($extra);
        if ($row['void']) {
            $voidBugs[] = $row['class'];
        }
        $format = static fn(array $names): string => $names === [] ? '-' : implode(', ', array_map(static fn($a) => '`' . $a . '`' . (in_array($a, $enumAttributes, true) ? '' : '*'), $names));
        $gap = $element === 'input' ? 'type-dependent' : $format($missing);
        $extraCell = ($spec === [] || $element === 'input') ? '-' : $format($extra);
        $ts = $tsByClass[$row['class']] ?? ($tsByElement[$element] ?? '-');
        $rows[] = sprintf(
            '| `%s` | `%s` | %s | %s | %s | %s | %s | %s | %s | %s |',
            $element,
            $row['class'],
            $row['dir'],
            $row['parent'],
            $tier,
            $gap,
            $extraCell,
            $tests($row),
            $ts,
            in_array($row['class'], $eelcDirect, true) ? 'yes' : '-'
        );
    }
}

ksort($domainCount);
$out = [];
$out[] = '# AX ElementFactory Inventory';
$out[] = '';
$out[] = '> Generated by `src/Sandbox/MeshFactory/_shared/generate-element-inventory.php --write`. Do not edit by hand; regenerate after changing elements, enums, or sandbox files.';
$out[] = '';
$out[] = 'This is the single working list for ElementFactory implementation work. Each row is one enum element (or one concrete class bound to it).';
$out[] = '';
$out[] = '## Tier Definitions';
$out[] = '';
$out[] = '| Tier | Meaning | Typical next step |';
$out[] = '|---|---|---|';
$out[] = '| Unbound | Enum case exists but no concrete class is bound to it. | Create the class (see [backlog](../behavior/BV-element-factory-implementation-backlog.md)). |';
$out[] = '| Stub | Class only binds the element; no element-specific attributes or behavior. Renders `<tag>` plus global attributes and content. | Model spec attributes in the nearest family abstract. |';
$out[] = '| Family | Inherits element-specific attributes from a family abstract; no leaf behavior. | Verify attribute completeness and rendered output. |';
$out[] = '| Behavioral | Leaf declares its own public behavior (children, composition, fluent helpers). | Harden behavior, escaping, and string/array parity. |';
$out[] = '';
$out[] = '## Summary';
$out[] = '';
$out[] = sprintf('- Enum elements: %d', count(FactoryElement::cases()));
$out[] = sprintf('- Concrete classes: %d', count($classes));
$out[] = sprintf('- Tiers: Unbound %d, Stub %d, Family %d, Behavioral %d', $tierCount['Unbound'], $tierCount['Stub'], $tierCount['Family'], $tierCount['Behavioral']);
$out[] = sprintf('- Spec attributes not yet modeled across curated elements: %d (a trailing `*` means the attribute is also missing from `FactoryElementAttribute`)', $gapTotal);
$out[] = sprintf('- Attributes allowed by a class but not defined for its element by the HTML Standard: %d', $extraTotal);
$out[] = sprintf('- Void elements that render a closing tag: %s', $voidBugs === [] ? 'none' : implode(', ', $voidBugs));
$out[] = '';
$out[] = '| Domain | Concrete classes |';
$out[] = '|---|---:|';
foreach ($domainCount as $domain => $count) {
    $out[] = sprintf('| %s | %d |', $domain, $count);
}
$out[] = '';
$out[] = '## Legend';
$out[] = '';
$out[] = '- Tests: uppercase `G` Generic, `F` Factory, `P` Params means a per-class sandbox script exists. Lowercase `g`, `f`, `p` means the class is only covered by a domain suite (Field, Form, Table) in that flavor. `-` means no sandbox coverage.';
$out[] = '- Spec attributes: non-global attributes the HTML Standard defines for the element that the class does not yet allow. Curated list lives in the generator. `input` is type-dependent and excluded from the automatic diff.';
$out[] = '- Allowed, not in spec: attributes the class allows (and therefore may render) that the HTML Standard does not define for the element. The MeshFactory-specific `access` pseudo attribute is ignored.';
$out[] = '- TS atom: closest Mesh UI Foundation Part/Module (`C:\_src\app-mesh-ui\src\library\Foundation`). TS atoms are composite wrappers, not 1:1 tags; see [TypeScript alignment](AX-element-factory-typescript-alignment.md).';
$out[] = '- EELC: concrete class is imported directly by APP-EELC facades or designers.';
$out[] = '';
$out[] = '## Inventory';
$out[] = '';
$out[] = '| Element | Class | Domain | Abstract parent | Tier | Spec attributes not modeled | Allowed, not in spec | Tests | TS atom | EELC |';
$out[] = '|---|---|---|---|---|---|---|---|---|---|';
foreach ($rows as $line) {
    $out[] = $line;
}
$out[] = '';
$out[] = '## Notes';
$out[] = '';
$out[] = '- `fieldset` is implemented by `Element/Form/Fieldset`, a concrete subclass of the abstract `FactoryElementFieldsetAbstract`. It stores an optional `FieldsetLabel`, and is used by fields, `FormButton` and form sections.';
$out[] = '- `tbody` and `tfoot` are bound by `TableRowBody` and `TableFooter`; `table` is bound by `TableBody` and `DataTableBody` (names do not match their tags).';
$out[] = '- Classes in `Element/Form` that use the `MvpLounge\MeshFactory\Element\Field` namespace (`InputText`, `InputEmailer`, `InputPassword`, `InputHidden`, `InputRadio`, `FormButton`, `SelectOption`, `SelectOptions`) only autoload through the Composer classmap, not PSR-4.';
$out[] = '';

$markdown = implode("\n", $out);

if (in_array('--write', $argv, true)) {
    $target = $repoRoot . '/docs/architecture/AX-element-factory-inventory.md';
    file_put_contents($target, $markdown);
    echo 'WROTE ' . $target . PHP_EOL;
    exit(0);
}

echo $markdown;
