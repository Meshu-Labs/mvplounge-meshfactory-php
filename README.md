# app-mvplounge-meshfactory
Browser UI elements generated through a PHP Factory model.

This README is the primary summary for the platform.

## Documentation Model

- Docs entrypoint and namespace summary: [docs/.instructions.md](docs/.instructions.md)
- ElementFactory pattern guide with invocation examples: [docs/architecture/AX-element-factory-pattern.md](docs/architecture/AX-element-factory-pattern.md)
- Element inventory (generated, one row per element): [docs/architecture/AX-element-factory-inventory.md](docs/architecture/AX-element-factory-inventory.md)
- Implementation backlog (Given-When-Then): [docs/behavior/BV-element-factory-implementation-backlog.md](docs/behavior/BV-element-factory-implementation-backlog.md)
- TypeScript alignment: [docs/architecture/AX-element-factory-typescript-alignment.md](docs/architecture/AX-element-factory-typescript-alignment.md)
- Detailed architecture encyclopedia: [docs/architecture/AX-overview.md](docs/architecture/AX-overview.md)
- Agent governance and operating policy: [AGENTS.md](AGENTS.md)

## Recent Repository Updates

- Adopted domain-coded documentation naming across docs domains.
- Domain codes now include `AX` (Architecture), `BV` (Behavior), `TK` (Task), and `AG` (Agents).
- Promoted [docs/.instructions.md](docs/.instructions.md) to the canonical docs entrypoint and index.
- Distributed governance/instruction content into domain-owned files for maintainability.
- Renamed clarification output location from `docs/clarifications/` to [docs/behavior](docs/behavior).
- Replaced monolithic governance text with routing entrypoints in [AGENTS.md](AGENTS.md) and [docs/agents/AG-repository-governance.md](docs/agents/AG-repository-governance.md).
- Standardized clarification report output naming to `BV-*.md`.

## Platform Summary

MeshFactory builds DOM and HTML element output through a predictable PHP factory structure:

- Enum layer defines elements and attributes.
- Abstract layer defines shared behavior and contracts.
- Concrete classes provide element-specific behavior.
- Attribute management remains the dynamic extension layer.

## Behavioral Clarification Workflow

Use the clarification workflow when evaluating new ideas, implementation examples, or edge-case behavior:

- Task definition: [docs/tasks/TK-architecture-clarification-task.md](docs/tasks/TK-architecture-clarification-task.md)
- Clarification reports folder: [docs/behavior](docs/behavior)

## Documentation Conventions

- Use domain-prefixed markdown names in docs domains using `{DomainCode}-{name}.md`.
- Domain codes: `AX` for Architecture, `BV` for Behavior, `TK` for Task, and `AG` for Agents.
- Examples: `AX-system-overview.md`, `BV-20261011-initial-meshfactory-distribution.md`, `TK-architecture-clarification-task.md`, and `AG-repository-governance.md`.
- Use lowercase directory names, for example architecture, tasks, and agents.
- Keep reserved index filenames in uppercase where conventional, for example README.md and AGENTS.md.

## Documentation Structure

- Docs entrypoint: docs/.instructions.md
- Architecture encyclopedia: docs/architecture/
- Behavioral clarifications: docs/behavior/
- Task workflows: docs/tasks/
- Agent governance docs: docs/agents/

## Development and Releases

Branch from `dev` and submit PRs to `dev`. Approved accounts or Copilot promote
`dev` to `main` through reviewed PRs. `main` refreshes
[Packagist](https://packagist.org/packages/mvplounge/meshfactory); approved
release accounts can run the **Publish** workflow on `main` to create versioned
releases.

An administrator must activate the supplied rulesets, set `dev` as the default
branch, and configure protected publishing environments before this is enforced.
See the [branching and publishing setup](docs/tasks/TK-quality-check-playbook.md#branching-and-publishing-setup-administrator).

## Installation

This package requires PHP 8.2 or later.

```bash
composer require mvplounge/meshfactory
```

Composer loads the package classes automatically. For manual bootstrap, include Composer's autoloader:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Quick Start

Every element is one class. Build it with a fluent chain or a params array, then render it:

```php
use MvpLounge\MeshFactory\Element\TextContent\Div;
use MvpLounge\MeshFactory\Element\InlineTextSemantics\Anchor;

echo (new Div())->addId('hero')->addClass('card')->addContent('Hello')->string();
// <div id="hero" class="card">Hello</div>

echo (new Anchor(['href' => '/home', 'target' => '_blank', 'content' => 'Home']))->string();
// <a class="generic-a" href="/home" target="_blank">Home</a>
```

Read [AX-element-factory-pattern.md](docs/architecture/AX-element-factory-pattern.md) for the full pattern, tables, forms, and extension recipes.

## Working With The Library

| Task | Command |
|---|---|
| Run the full sandbox suite | `composer test` |
| Regenerate the element inventory | `composer inventory` |
| Build an installable artifact | `composer artifact -- --version=dev-local` |

Packaging, local consumption through Composer, and testing inside the EELC instance are covered in [TK-package-and-xamppire-consumption.md](docs/tasks/TK-package-and-xamppire-consumption.md). Known gaps are tracked as Given-When-Then stories in [BV-element-factory-implementation-backlog.md](docs/behavior/BV-element-factory-implementation-backlog.md).
