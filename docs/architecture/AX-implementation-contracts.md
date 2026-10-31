# AX Implementation Contracts

This document defines implementation contracts for MeshFactory architecture and code generation.

## Abstract Base Class Migration and Organization

All factory element abstractions must reside in `/src/Labs/MeshFactory/Abstract/`.

Migration requirements:

- Move abstract classes from `/Element/` subdirectories to `/Abstract/`.
- Update namespace declarations to `MvpLounge\MeshFactory\Abstract`.
- Update relative `require_once` paths:
  - Parent classes: `__DIR__ . '/FactoryElementAbstract.php'`
  - Sibling abstracts: `__DIR__ . '/FactoryElementFieldAbstract.php'`
  - Enums: `__DIR__ . '/../Enum/FactoryElement.php'`
- Keep concrete implementations in `/src/Labs/MeshFactory/Element/{Domain}/`.
- Concrete implementations must require abstracts from `/Abstract/`.
- Every `require_once` target must exist and match its on-disk case (the CI runner is case-sensitive). Known violation tracked as `EF-041`: `FactoryElementHtml5Abstract` requires two files that do not exist.

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
  - `src/Labs/MeshFactory/Element/Form/*`
- Do not create or reference classes in the deprecated plural namespace:
  - `MvpLounge\MeshFactory\Element\Forms\*`
  - `src/Labs/MeshFactory/Element/Forms/*`
- Known exception (tracked as `EF-040`): the field classes `TextInput`, `EmailerInput`, `PasswordInput`, `HiddenInput`, `RadioInput`, `FormButton`, `SelectOption`, and `SelectOptions` live in `Element/Form/` but declare namespace `MvpLounge\MeshFactory\Element\Field`. They resolve through the Composer `classmap` in `composer.json`, not PSR-4. Do not add new classes with a namespace that differs from their folder.

## HTML Element and Attribute Authority

Use these references as authoritative for elements and attributes:

- W3C HTML Standard: https://html.spec.whatwg.org/
- MDN HTML Docs: https://developer.mozilla.org/en-US/docs/Web/HTML/

Research order:

1. Validate in W3C spec.
2. Confirm practical behavior in MDN.
3. Verify enum coverage in `src/Labs/MeshFactory/Enum/`.
4. Add missing enums before wiring behavior.

## HTML Element Domain Organization

HTML element classes under `src/Labs/MeshFactory/Element/` are apportioned into source-of-truth domains (MDN element groups).

- `Main root` is normalized to `Root`.
- `Document metadata` is normalized to `MetaData`.
- Canonical element classes live under `Element/{Domain}/`.
- Each element class namespace must match its folder domain:
  - `MvpLounge\MeshFactory\Element\{Domain}\{Class}`
- Plain elements extend `MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract`. There is no `Element\Html` namespace and no `HtmlElement` base class.
- Keep reserved keyword-safe class names where needed:
  - `object` -> `ObjectElement`
  - `var` -> `VarElement`

Use the canonical mapping reference:

- `docs/architecture/AX-html-element-domain-mapping.md`
- `docs/architecture/AX-element-factory-inventory.md` (generated, per element)

## Fluent Interface Contract

- All `add*()` methods must return `$this` or the correct fluent type.
- Preserve chainability for all builder-style APIs.

## Enum-Based Attribute Allowlisting

- Use enum-backed allowlists for supported elements and attributes.
- Validate with strict comparisons.
- Return `NULL` when an attribute is outside the allowlist.

## Parameter Processing Convention

- Constructors accept `$params = []`.
- Parent constructor orchestrates parameter dispatch.
- `__process_*()` methods each own one logical parameter group.

## Return Type Safety and Null Handling

- Use explicit return types.
- Use null-safe access where needed.
- Use sensible defaults for empty strings and arrays when contract requires non-null outputs.

## View Output Convention

When rendering variables in views, use null-coalescing fallback:

```php
<?= $value ?? '' ?>
```