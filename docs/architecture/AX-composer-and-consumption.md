# Composer and Consumption

## Install

composer require mvplounge/meshfactory

## Autoload

require __DIR__ . '/vendor/autoload.php';

Autoloading is PSR-4 (`MvpLounge\MeshFactory\` to `src/Labs/MeshFactory/`) plus a `classmap` of the same folder. The classmap is required today because the field classes in `Element/Form/` use the `Element\Field` namespace (`EF-040`).

## Package Validation

composer validate --strict --no-check-publish

## Package Contents Contract

The distributable (GitHub zipball, `composer archive`, and the artifact built by `scripts/build-artifact.php`) contains only:

- `composer.json`
- `src/Labs/MeshFactory/**`

Docs, sandbox, scripts, `.github`, and agent files are excluded. Three places must agree:

1. `.gitattributes` export rules (`* export-ignore`, then un-ignore `composer.json` and `src/Labs/MeshFactory`). This governs the GitHub zipball that Composer downloads for `dev-*` and tagged versions.
2. `composer.json` `archive.exclude` (with `.gitattributes`). This governs `composer archive`.
3. The whitelist in `scripts/build-artifact.php`.

Parity of (2) and (3) was verified: both produce 195 entries with no difference. Re-check after changing any of the three.

## Entry Points

| Need | Command |
|---|---|
| Run all sandbox scripts | `composer test` |
| Regenerate the element inventory | `composer inventory` |
| Build an installable artifact | `composer artifact -- --version=dev-local` |

CI (`.github/workflows/quality.yml`) validates metadata, lints PHP, runs `composer test`, builds an artifact, and uploads it as `mvplounge-meshfactory-artifact`.

## Consumption Modes

Local and CI testing modes (`path`, `artifact`, GitHub branch) and the EELC procedure are in [TK-package-and-xamppire-consumption.md](../tasks/TK-package-and-xamppire-consumption.md). Composer's `artifact` repository requires a `version` inside the zip's `composer.json`; the build script injects it.

## Packaging Policy

Agent and local workflow documents are excluded from package archive artifacts.

See:

- .gitattributes export-ignore entries
- composer.json archive.exclude entries
