# Params Sandbox Template

This task document defines the comment scaffold used for generated `Params` sandbox scripts.

## Purpose

- Provide a stable template for Human or Agent generation.
- Keep the executable flow readable while leaving narrow edit regions for generation parameters.
- Preserve a consistent comment boundary so generators can fill only the intended sections.

## Canonical Scaffold

Use the current `Params` sandbox file structure as the template shape:

- `// Template reference: docs/tasks/TK-params-sandbox-template.md`
- `#region Test Definition`
- Human or Agent generation notes inside the test-definition region.
- `#region Error Handling`
- Human or Agent generation notes inside the error-handling region.

## Editing Boundaries

- Keep repository bootstrap and shared helper imports outside the editable regions.
- Preserve the region markers so generated files remain machine-readable.
- Allow Human or Agent-provided generation parameters only inside the test-definition and error-handling sections.
- Keep success and error diagnostics in the scaffold unless the generated test explicitly requires different output.
- Close the `#region Error Handling` block before `exit(1)` so the generated scaffold keeps the full error handler inside the region.

## Generation Intent

- For new elements identified from the source of truth, generate a new `Params` sandbox file from this scaffold.
- For existing `Params` scripts, keep the scaffold consistent so the test body can be regenerated without changing the surrounding structure.
- Use the scaffold together with the sandbox-specific element scope and factory class name.

## References

- Sandbox QA guidance: `docs/tasks/TK-quality-check-playbook.md`
- Behavioral QA framework: `docs/behavior/BV-quality-assurance-framework.md`
- Task index: `docs/tasks/TK-overview.md`