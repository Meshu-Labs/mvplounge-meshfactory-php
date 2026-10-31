# AG APP-EELC Referential Instructions

This document is a handoff reference for agents working in APP-EELC that consume MeshFactory.

## Canonical Entry Points

- Canonical HTML element source-of-truth classes live under `src/Labs/MeshFactory/Element/{Domain}/`.
- APP-EELC should use canonical domain classes for all integrations.

## Consumption Rules for APP-EELC

- Import canonical classes from `Element/{Domain}`.
- Do not use `Element/Html5/*` or `Element/Links/Anchor` imports.

## Output API Contract

- Use `string()` or `compileAsHtmlString(): ?string` for HTML output. The EELC facades use `string()`.
- Use `compileAsArray(): ?array` (alias `compile()`) for structured payload output.
- Use `compileAsJson(): ?string` only on forms (`PostForm`, `AjaxForm`) today. It does not exist on other elements; making it universal is tracked as `EF-043`.
- Avoid `build()` in new code. It echoes and returns nothing.
- Composite elements (`TableBody`, `DataTableBody`, `PostForm`) carry their children in `compileAsArray()` and `prepare()`; `string()` returns only the outer tag until `EF-005` is done.

## Facade Map (APP-EELC)

| EELC facade (`lab_center/libraries/resource/ui`) | Alias | MeshFactory classes it returns |
|---|---|---|
| `Element.php` | `lc_element` | `P`, `H1`-`H6`, `Hl`, `Aside`, `Content`, `Header`, `Figure`, `Main`, `Img` |
| `Links.php` | `lc_links` | `Anchor` |
| `Table.php` | `lc_table` | `TableBody`, `DataTableBody`, `TableRow`, `TableCell`, `TableHeader` |
| `Field.php`, `Form.php` | | assemble raw HTML today (`EF-073`); designers import `TextInput`, `EmailerInput`, `PasswordInput`, `HiddenInput`, `RadioInput`, `SelectOption`, `FormButton`, `PostForm`, `AjaxForm` directly |

Rules for new facade code:

1. Create the element, call the fluent `add*()` methods, return `string()`.
2. Pass `content` in the constructor array or through `addContent()`. Use `addData()` and `addClass()` instead of `data` or `user` params (`EF-004`).
3. Keep escaping in mind: attribute values are not encoded by the factory (`EF-003`). Encode untrusted values before passing them.

## Installing A Build Into EELC

Follow `docs/tasks/TK-package-and-xamppire-consumption.md`.

## Verification Expectations

- Before APP-EELC release integration, run MeshFactory sandbox coverage:
  - `composer test` or `src/Sandbox/MeshFactory/run-all.php`
- Check the backlog (`docs/behavior/BV-element-factory-implementation-backlog.md`) for open stories that affect the elements your facade uses.

## Migration Checklist for APP-EELC Agent

1. Identify existing `Html5` and `Links\Anchor` imports.
2. Map each import to canonical `{Domain}` class under `Element/{Domain}`.
3. Update imports in APP-EELC feature code.
4. Keep runtime behavior identical by comparing rendered output where practical.
5. Remove legacy wrapper imports from active code paths.

## Mapping Reference

- Full mapping document:
  - `docs/architecture/AX-html-element-domain-mapping.md`