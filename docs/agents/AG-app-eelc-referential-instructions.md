# AG APP-EELC Referential Instructions

This document is a handoff reference for agents working in APP-EELC that consume MeshFactory.

## Canonical Entry Points

- Canonical HTML element source-of-truth classes live under `src/MvpLounge/MeshFactory/Element/{Domain}/`.
- APP-EELC should use canonical domain classes for all integrations.

## Consumption Rules for APP-EELC

- Import canonical classes from `Element/{Domain}`.
- Do not use `Element/Html5/*` or `Element/Links/Anchor` imports.

## Output API Contract

- Use `compleAsHtmlString(): ?string` for HTML output.
- Use `compileAsArray(): ?array` for structured payload output.
- Use `compileAsJson(): ?string` when JSON transport is required.

## Verification Expectations

- Before APP-EELC release integration, run MeshFactory sandbox coverage:
  - `src/MvpLounge/Sandbox/MeshFactory/run-all.php`

## Migration Checklist for APP-EELC Agent

1. Identify existing `Html5` and `Links\Anchor` imports.
2. Map each import to canonical `{Domain}` class under `Element/{Domain}`.
3. Update imports in APP-EELC feature code.
4. Keep runtime behavior identical by comparing rendered output where practical.
5. Remove legacy wrapper imports from active code paths.

## Mapping Reference

- Full mapping document:
  - `docs/architecture/AX-html-element-domain-mapping.md`