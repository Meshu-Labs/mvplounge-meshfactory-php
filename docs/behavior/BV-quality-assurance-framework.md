# BV Quality Assurance Framework

This document defines behavioral quality gates for namespace-driven MeshFactory changes.

## Scope

Apply this framework to:

- Any touched PHP file.
- All related files in impacted domains.
- All concrete implementations when parent abstracts change.
- Path, namespace, or autoload-affecting edits.

Operational command procedures live in `docs/tasks/TK-quality-check-playbook.md`.

## When Quality Checks Are Mandatory

Run quality checks:

1. After any file edit.
2. After abstract migrations.
3. After `require_once` path changes.
4. After namespace changes.
5. After bulk operations across a domain.

## Attribute Quality Check Phases

### Phase 1: Syntax Verification

- Execute syntax checks using the single-file and domain procedures in `docs/tasks/TK-quality-check-playbook.md`.

### Phase 2: UTF-8 No-BOM Verification

- Execute encoding verification using the procedures in `docs/tasks/TK-quality-check-playbook.md`.
- Expected first bytes: `3C 3F 70` (`<?php`).
- Invalid BOM bytes: `EF BB BF`.

### Phase 3: Namespace and Path Verification

- Namespace matches file location.
- `<?php` is first bytes in file.
- `require_once` paths use `__DIR__` relative format.
- Concrete classes reference abstract parents from `/Abstract/`.

### Phase 3.1: Array Formatting Verification

- Verify no PHP array has a trailing comma on the final array item.
- Apply this as a global style rule across all touched and impacted files.

### Phase 3.5: Output API Contract Verification

- `compleAsHtmlString()` returns `?string`.
- `compileAsArray()` returns `?array`.
- `compileAsJson()` returns JSON payload string or `NULL` when encoding fails.
- Sandbox and usage examples call canonical output methods.

### Phase 3.6: HTML Domain Namespace Verification

- HTML element class folder path under `Element/Html/*` matches declared namespace.
- Domain folder names follow source-of-truth normalization:
	- `Main root` -> `Root`
	- `Document metadata` -> `MetaData`
- Mapping doc stays aligned with code:
	- `docs/architecture/AX-html-element-domain-mapping.md`

### Phase 3.7: Form Namespace Consolidation Verification

- Form classes must use `MvpLounge\MeshFactory\Element\Form\*`.
- No runtime references may remain to `MvpLounge\MeshFactory\Element\Forms\*`.
- Remove deprecated `src/MvpLounge/MeshFactory/Element/Forms/*` files after migration.

### Phase 3.8: Abstract Depth Verification

- Default hierarchy must not exceed two abstract levels from `FactoryAbstract`.
- Field families may use up to four levels from `FactoryAbstract`.
- Confirm field input classes continue to route through `FactoryElementFieldInputAbstract` when applicable.

### Phase 3.9: Factory Sandbox Explicit Invocation Verification

- In `Sandbox/MeshFactory/*/Factory/*-sandbox.php`, enforce explicit per-file fluent invocation behavior.
- Do not allow dynamic attribute-to-method mapping helpers in Factory strategy examples.
- Enforce scaffold and boundary conformance using:
	- `docs/tasks/TK-factory-sandbox-template.md`
	- `docs/tasks/TK-quality-check-playbook.md`

### Phase 3.10: Attribute Ownership and Fluent Alias Verification

- `FactoryElementAbstract::$AllowedFactoryElementAttributes` must not expose domain-specific opening-tag attributes.
- Downstream abstract/concrete classes must own only the attributes they render in `getFactoryAttributePropertyCollection()`.
- Each allowed attribute must have a canonical fluent `add*` method, directly or through an alias to specialized legacy methods.

### Phase 3.11: Params Sandbox Explicit Configure Flow Verification

- In `Sandbox/MeshFactory/*/Params/*-sandbox.php`, enforce the explicit configure flow and no constructor-scoped params rule.
- Validate flow and output behavior using:
	- `docs/tasks/TK-params-sandbox-template.md`
	- `docs/tasks/TK-quality-check-playbook.md`

### Phase 3.12: Params Template Boundary Verification

- Enforce Params generation boundaries and scaffold ownership from `docs/tasks/TK-params-sandbox-template.md`.

### Phase 3.13: Factory Template Boundary Verification

- Enforce Factory generation boundaries and scaffold ownership from `docs/tasks/TK-factory-sandbox-template.md`.

### Phase 4: Legacy Cleanup Verification

- Remove obsolete legacy files after migration.
- Confirm no remaining references to removed files.

### Phase 5: Full Element Coverage Verification

- Execute all sandbox suites via `src/MvpLounge/Sandbox/MeshFactory/run-all.php`.
- Confirm Generic, Params, and Factory strategies execute for full Element coverage.
- Confirm all compile pathways are exercised by coverage suites:
	- `compileAsArray()`
	- `compile()`
	- `compileAsJson()` where implemented
	- `compleAsHtmlString()` where implemented
	- `string()` where implemented
- Confirm runtime output has no PHP warnings or sandbox error markers.
- Required completion marker: `All sandbox scripts executed.`

## Required Outcomes

- No syntax errors across touched and affected files.
- UTF-8 no-BOM encoding for namespace-driven PHP files.
- No stale path references after migration.
- No static parent-call anti-patterns where `parent::` is required.