# AX Implementation Contracts

This document defines implementation contracts for MeshFactory architecture and code generation.

## Abstract Base Class Migration and Organization

All factory element abstractions must reside in `/src/MvpLounge/MeshFactory/Abstract/`.

Migration requirements:

- Move abstract classes from `/Element/` subdirectories (Field, Form, Links, Table) to `/Abstract/`.
- Update namespace declarations to `MvpLounge\MeshFactory\Abstract`.
- Update relative `require_once` paths:
  - Parent classes: `__DIR__ . '/FactoryElementAbstract.php'`
  - Sibling abstracts: `__DIR__ . '/FactoryElementFieldAbstract.php'`
  - Enums: `__DIR__ . '/../Enum/FactoryElement.php'`
- Keep concrete implementations in `/src/MvpLounge/MeshFactory/Element/{Domain}/`.
- Concrete implementations must require abstracts from `/Abstract/`.

## Concrete Implementation Update Requirements

When abstracts are migrated, update all concrete implementations immediately.

- Update `require_once` paths to `/Abstract/`.
- Replace static parent calls with `parent::` where appropriate.
- Ensure no `use` statements point to legacy abstract locations.

## Abstract Depth Contract

- Default maximum abstract depth from `FactoryAbstract` is two levels.
  - Canonical default path: `FactoryAbstract -> FactoryElementAbstract -> FactoryElement{Domain}Abstract`.
- Field families are an approved exception and may use up to four abstract levels.
  - Approved field path: `FactoryAbstract -> FactoryElementAbstract -> FactoryElementFieldAbstract -> FactoryElementFieldInputAbstract`.
- Do not introduce additional abstract layers outside this contract.

## Form Namespace Consolidation

- Use the singular namespace and folder for form elements:
  - `MvpLounge\MeshFactory\Element\Form\*`
  - `src/MvpLounge/MeshFactory/Element/Form/*`
- Do not create or reference classes in the deprecated plural namespace:
  - `MvpLounge\MeshFactory\Element\Forms\*`
  - `src/MvpLounge/MeshFactory/Element/Forms/*`

## HTML Element and Attribute Authority

Use these references as authoritative for elements and attributes:

- W3C HTML Standard: https://html.spec.whatwg.org/
- MDN HTML Docs: https://developer.mozilla.org/en-US/docs/Web/HTML/

Research order:

1. Validate in W3C spec.
2. Confirm practical behavior in MDN.
3. Verify enum coverage in `src/MvpLounge/MeshFactory/Enum/`.
4. Add missing enums before wiring behavior.

## HTML Element Domain Organization

HTML element classes under `src/MvpLounge/MeshFactory/Element/Html/` must be apportioned into source-of-truth domains.

- `Main root` is normalized to `Root`.
- `Document metadata` is normalized to `MetaData`.
- Canonical source-of-truth element classes live under `Element/Html/{Domain}/`.
- Each element class namespace must match its folder domain:
  - `MvpLounge\MeshFactory\Element\Html\{Domain}\{Class}`
- Shared HTML base class remains:
  - `MvpLounge\MeshFactory\Element\Html\HtmlElement`
- Keep reserved keyword-safe class names where needed:
  - `object` -> `ObjectElement`
  - `var` -> `VarElement`

Use the canonical mapping reference:

- `docs/architecture/AX-html-element-domain-mapping.md`

## Fluent Interface Contract

- All `add*()` methods must return `$this` or the correct fluent type.
- Preserve chainability for all builder-style APIs.

## Enum-Based Attribute Allowlisting

- Use enum-backed allowlists for supported elements and attributes.
- Validate with strict comparisons.
- Return `NULL` when an attribute is outside the allowlist.

## Attribute Getter Modeling Contract

- Do not place inline `in_array(...)?...:NULL` ternary expressions directly in `getFactoryAttributePropertyCollection()`.
- Model each allowlist-gated attribute read as a dedicated `get*` method on the owning abstract class.
- Getter methods must accept the resolved allowlist and follow the canonical pattern:

```php
public function getFactoryElementTableScope(array $allowed): ?string
{
  return in_array(FactoryElementAttribute::SCOPE->value, $allowed, TRUE) ? $this->FactoryElementTableScope : NULL;
}
```

- `getFactoryAttributePropertyCollection()` should compose values by calling these `get*` methods.
- Concrete classes must not override inherited `__process_*` or `get*` methods unless the derivative introduces domain-specific behavior that cannot live in the abstract.
- Any concrete override exception for non-derivative classes must be explicitly approved in the `Quality Check: Concrete Override Audit` task registry and documented with rationale.

## Parameter Processing Convention

- Constructors accept `$params = []`.
- Parent constructor orchestrates parameter dispatch.
- `__process_*()` methods each own one logical parameter group.

## Element Param Resolution Contract

- Callers should pass element intent through constructor params using `['element' => '<tag>']`.
- `FactoryElementAbstract::__process_element()` must route through `addElement()`.
- `addElement()` must resolve against `FactoryElement::tryFrom(...)` and set `FactoryElement` only when enum-backed value matches.
- High-level helpers (for example heading helpers) should forward `element` params into concrete factories rather than hard-coding local allowlists.
- Preferred call shape:

```php
public function H4(): FactoryElementAbstract
{
  return $this->H(['element' => 'h4']);
}
```

## Array Formatting Contract

- Do not use a trailing comma on the final item in PHP array declarations.
- Applies to all array styles used in this repository, including short arrays (`[]`) and nested arrays.

## Return Type Safety and Null Handling

- Use explicit return types.
- Use null-safe access where needed.
- Use sensible defaults for empty strings and arrays when contract requires non-null outputs.

## Output Method Contract

- Use `compleAsHtmlString(): ?string` as the canonical HTML rendering method.
- Use `compileAsArray(): ?array` as the canonical structured compile method.
- Use `compileAsJson(): ?string` for headless transport payloads where JSON output is required.

## View Output Convention

When rendering variables in views, use null-coalescing fallback:

```php
<?= $value ?? '' ?>
```