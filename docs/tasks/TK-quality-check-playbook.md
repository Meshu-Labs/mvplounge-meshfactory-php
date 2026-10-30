# TK Quality Check Playbook

This playbook provides operational procedures for running MeshFactory quality checks.

Generated report storage policy and scripting references are defined in:

- `docs/tasks/TK-generated-artifacts-storage-and-reporting.md`

Artifact storage enforcement:

- Store generated files in `/.tmp/{filetype}/` folders (`json/`, `txt/`, `php/`, `tmp/`).
- Do not write generated artifacts directly into `/.tmp/` root.

## Single File Checks

Syntax:

```powershell
& "C:/xampp_devops_test/php/php.exe" -l "<file>"
```

Encoding:

```powershell
$bytes = [System.IO.File]::ReadAllBytes("<file>") | Select-Object -First 3
($bytes | ForEach-Object { $_.ToString('X2') }) -join ' '
```

Expected first bytes: `3C 3F 70`

## Domain-Wide Checks

Use VS Code tasks from `.vscode/tasks.json`:

- `Quality Check: Current File`
- `Quality Check: Form Domain`
- `Quality Check: Field Domain`
- `Quality Check: Table Domain`
- `Quality Check: Links Domain`
- `Quality Check: All Domains`
- `Quality Check: Concrete Override Audit`

## Abstraction Depth Audit (Static)

Rule set:

- Default domains: maximum two abstract levels from `FactoryAbstract`.
- Field domain exception: up to four abstract levels from `FactoryAbstract`.

Current approved field chain:

- `FactoryAbstract -> FactoryElementAbstract -> FactoryElementFieldAbstract -> FactoryElementFieldInputAbstract`

Static inheritance scan:

```powershell
Get-ChildItem "src/MvpLounge/MeshFactory/Abstract" -Filter "*.php" |
ForEach-Object {
	$matches = Select-String -Path $_.FullName -Pattern "class\s+\w+\s+extends\s+\w+" -AllMatches
	foreach ($m in $matches.Matches) {
		[pscustomobject]@{
			File = $_.Name
			Declaration = $m.Value
		}
	}
} | Format-Table -AutoSize
```

Field concrete verification:

```powershell
Get-ChildItem "src/MvpLounge/MeshFactory/Element/Field" -Filter "*.php" |
ForEach-Object {
	Select-String -Path $_.FullName -Pattern "extends\s+FactoryElementField(Input)?Abstract" |
	ForEach-Object {
		[pscustomobject]@{
			File = $_.Filename
			Match = $_.Line.Trim()
		}
	}
} | Format-Table -AutoSize
```

Expected outcomes:

- No non-field abstract chain exceeds two levels from `FactoryAbstract`.
- Input-style field classes extend `FactoryElementFieldInputAbstract`.
- Other field classes extend `FactoryElementFieldAbstract` unless there is a documented contract exception.

## Array Style Check (Global)

Rule: the last item in a PHP array must not end with a trailing comma.

Quick check:

```powershell
$files = Get-ChildItem "src" -Recurse -Filter "*.php"
$violations = @()
foreach ($f in $files) {
	$content = Get-Content -Raw $f.FullName
	if ([regex]::IsMatch($content, ',\s*\r?\n\s*\];')) {
		$violations += $f.FullName
	}
}
$violations
"Total violations: $($violations.Count)"
```

## Abstract Getter Contract Check

Rules:

- Do not use inline allowlist ternary expressions inside `getFactoryAttributePropertyCollection()`.
- Required pattern is dedicated `get*` methods that accept `array $allowed` and return nullable typed values.

Quick check for inline violations in abstract classes:

```powershell
Get-ChildItem "src/MvpLounge/MeshFactory/Abstract" -Filter "*.php" |
ForEach-Object {
	$hits = Select-String -Path $_.FullName -Pattern "in_array\(FactoryElementAttribute::.+\?\s*\$this->.+:\s*NULL" -AllMatches
	if ($hits) {
		[pscustomobject]@{
			File = $_.Name
			Count = $hits.Count
		}
	}
} | Format-Table -AutoSize
```

Quick check for compliant getter signatures:

```powershell
Get-ChildItem "src/MvpLounge/MeshFactory/Abstract" -Filter "*.php" |
ForEach-Object {
	Select-String -Path $_.FullName -Pattern "public function getFactoryElement\w+\(array \$allowed\): \?\w+" |
	ForEach-Object {
		[pscustomobject]@{
			File = $_.Filename
			Line = $_.Line.Trim()
		}
	}
} | Format-Table -AutoSize
```

## Concrete Override Audit

Rules:

- Concrete Element classes must not define local `__process_*` or `getFactoryElement*` methods when inherited abstract behavior is sufficient.
- Exception cases are allowed only for class-specific behavior and must be explicitly listed in the approved exceptions registry inside the `Quality Check: Concrete Override Audit` task in `.vscode/tasks.json`.
- Non-derivative concrete classes with unapproved local overrides are a quality failure.

Run the enforcement task:

```powershell
Write-Host "Run task: Quality Check: Concrete Override Audit"
```

Maintenance rule for approved exceptions:

- Keep each approved class mapped to explicit method names.
- When adding a new exception, update both:
	- `.vscode/tasks.json` approved exceptions registry
	- `docs/architecture/AX-implementation-contracts.md` rationale for the exception

## Sandbox Test-Type Standard

Library sandbox suites are organized under `src/MvpLounge/Sandbox/{Library}/`.

For MeshFactory, sandbox tests are split by test type under each domain folder in `src/MvpLounge/Sandbox/MeshFactory/`:

- `Generic/`
- `Factory/`
- `Params/`

Each domain should provide scripts per type using structured try/catch output.

Within each strategy folder, scripts should be class-based:

- `{FactoryElementClassName}-sandbox.php`

The test-type scripts must follow the established sandbox style:

- Standalone file per FactoryElement class and strategy.
- Local assertion checks in each script.
- Shared helper support is allowed for repeatable parameter and compile-path setup.
- Params strategy flow and boundary details are canonical in `docs/tasks/TK-params-sandbox-template.md`.
- Factory strategy invocation and boundary details are canonical in `docs/tasks/TK-factory-sandbox-template.md`.
- Params strategy scripts must not pass scoped params through constructor arguments.
- Dynamic attribute-to-method mapping (for example generated `add*` method names from attribute strings) is not allowed in Factory strategy sandbox examples.
- Structured `ERROR_CLASS`, `ERROR_MESSAGE`, `ERROR_FILE`, and `ERROR_TRACE` output on failure.

The scripts are written as explicit examples with per-class readability, while shared helper functions keep repeated setup small and consistent.

## Factory Sandbox Template

Factory strategy scaffold ownership and editable boundaries are defined in:

- `docs/tasks/TK-factory-sandbox-template.md`

Run the MeshFactory sandbox suite through the library runner:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"
```

## Params Sandbox Template

Params strategy scaffold ownership and editable boundaries are defined in:

- `docs/tasks/TK-params-sandbox-template.md`

## Comprehensive Element Coverage Suites

All concrete classes under `src/MvpLounge/MeshFactory/Element/` must be covered using domain-first sandbox organization.

Required structure:

- One sandbox folder per Element domain under `src/MvpLounge/Sandbox/MeshFactory/{Domain}/`
- Three strategy folders in each domain folder:
	- `Generic/`
	- `Params/`
	- `Factory/`

- One class-based sandbox script per concrete element class in each strategy:
	- `{FactoryElementClassName}-sandbox.php`

Domain suites should auto-discover concrete classes in their matching Element domain and validate:

- Generic strategy: default construction and core compile/render methods.
- Params strategy: constructor-driven attribute injection plus compile/render methods.
- Factory strategy: fluent/configure usage plus compile/render methods.

The suites must remain warning-free and include compile pathway checks for:

- `compileAsArray()`
- `compile()`
- `compileAsJson()` when implemented
- `compleAsHtmlString()` when implemented
- `string()` when implemented

Parameter restriction rule:

- Sandbox params must only use attributes from:
	- `FactoryAbstract::$FactoryElementAttributes`
	- the active class-chain `AllowedFactoryElementAttributes`

Attribute ownership rule:

- `FactoryElementAbstract::$AllowedFactoryElementAttributes` must remain empty.
- Non-global attribute ownership must be declared downstream in the most specific abstract or concrete class that supports the rendered property.

Canonical fluent setter rule:

- For each allowed attribute, expose a canonical `add*` method using normalized attribute naming.
- Legacy specialized methods are allowed only when a canonical alias exists (for example `addType()` delegating to a specialized implementation).

Refactor trigger rule:

- If more than five derived FactoryElement classes inherit `AllowedFactoryElementAttributes` they do not use, create or refine an intermediate `FactoryElement*Abstract` so opening-tag attribute exposure matches real usage.

Quick run:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"
```

Expected terminal tail:

- `All sandbox scripts executed.`

## Source-of-Truth Research and Validation Method

Use this method when updating abstract inheritance and element grouping.

1. Source-of-truth research:
	- Review MDN Elements reference:
	  - `https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements`
	- Confirm any element-specific behavior in the target MDN element pages.
2. Inventory extraction from code:
	- Parse all concrete declarations under `src/MvpLounge/MeshFactory/Element/`.
	- Record domain folder, class name, and `extends` parent.
3. Abstract alignment:
	- Ensure each Element domain inherits from the matching `FactoryElement{ElementGroup}Abstract`.
	- Keep special-purpose families (`Field`, `Form`, `Table`, `Link`) on their dedicated abstract chains.
4. Validation sequence:
	- Lint all abstract files:
	  - `Get-ChildItem "src/MvpLounge/MeshFactory/Abstract" -Filter "*.php" | ForEach-Object { & "C:/xampp_devops_test/php/php.exe" -l $_.FullName }`
	- Lint all element files:
	  - `Get-ChildItem "src/MvpLounge/MeshFactory/Element" -Recurse -Filter "*.php" | ForEach-Object { & "C:/xampp_devops_test/php/php.exe" -l $_.FullName }`
	- Run full sandbox suite:
	  - `& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"`
5. Documentation update:
	- Update `docs/architecture/AX-element-group-abstract-inventory.md` with the current mapping and counts.
	- Update architecture family responsibilities when new abstract groups are introduced.

## Bulk No-BOM Rewrite Procedure

```powershell
$content = Get-Content -Path '<file>' -Raw
[System.IO.File]::WriteAllText('<file>', $content, [System.Text.UTF8Encoding]::new($false))
```

After rewriting, rerun syntax and encoding checks.

## Clarification Report Generation

Use task: `Architecture Clarification: Create Report`

Outputs are written to `docs/behavior/` with `BV-` prefixed filenames.

## Branching and Publishing Setup (Administrator)

These files do not activate repository settings by themselves. An administrator must complete this setup:

1. Install the workflows on both `main` and `dev` before enabling protection. The branch-policy workflow uses `pull_request_target` to evaluate trusted base-branch code; it never checks out or executes PR code. The quality workflow runs untrusted PR code with read-only permissions and no publishing secrets.
2. In Settings → General, change the default branch to `dev`.
3. In Settings → Rules → Rulesets, import `.github/rulesets/dev.json` and `.github/rulesets/main.json`. Confirm both are active, with no bypass actors. Both require one approval, approval of the latest push, resolved discussions, current passing `Branch policy` and `PHP quality` checks from GitHub Actions, and prohibit force pushes and deletion. Requiring PRs blocks direct pushes.
4. Keep merge commits enabled. Merge promotion PRs with **Create a merge commit**, not squash or rebase, so repeated `dev` → `main` promotions retain shared history. After each promotion, create a temporary synchronization branch from the latest `dev`, merge `main` into it, and submit a reviewed PR back to `dev` using a merge commit before the next promotion. If `dev` advances, update the synchronization branch with `dev` again. This avoids deadlocking protected branches when development continues during promotion; strict status checks require `dev` to include the latest `main`. Bring developer branches up to date with `dev` before merging. GitHub cannot enforce the original branch point.
5. Create environments named `packagist` and `release`. For each, select **Selected branches and tags**, allow only the **branch** `main`, and add required reviewers if your GitHub plan supports them. Do not allow deployment from tags or developer branches. Environment restrictions are essential: workflow guards alone can be edited on a feature branch.
6. In the `packagist` environment only, add `PACKAGIST_USERNAME` and `PACKAGIST_API_TOKEN` secrets for a Packagist maintainer with access to `mvplounge/meshfactory`. Prefer a package-scoped update token. Do not place these secrets at repository scope.
7. In the existing Packagist package settings, verify the repository URL is `https://github.com/Meshu-Labs/mvplounge-meshfactory-php`. Updating the wrong repository will not update this package. The workflow requests a Packagist refresh; it does not upload an artifact. Packagist indexes branches and tags, including `dev` as a development version; consumers should use stable tagged versions for releases.
8. Protect release tags (`v*`) against unauthorized creation, updates, and deletion using an administrator-managed tag ruleset. Allow the release automation to create tags without allowing developers to rewrite them. Account for any other organization rulesets.

Developers branch from `dev` and open PRs back to `dev`. Promotion PRs must come from this repository's `dev` branch, target `main`, and be authored by `mcs-labs-dk`, `meshucs`, `Copilot`, or `copilot-swe-agent[bot]`. Copilot is subject to the same review and check requirements; it has no protection bypass. Open promotion PRs manually or ask Copilot to open them; there is no automatic PR-creation workflow.

Merges into `main` automatically request a Packagist update. To release, `mcs-labs-dk` or `meshucs` runs **Publish** using **Run workflow**, selecting `main` and a new stable tag such as `v1.0.0`. The workflow tags the exact `main` commit selected at dispatch, creates a GitHub release, and refreshes Packagist. Composer derives versions from Git tags rather than a fixed `version` field. Publishing needs no source checkout or Composer execution.

If Packagist fails after a release, rerun only the failed publishing job; do not reuse the release tag to create another release. If release creation fails after tag creation, an administrator must inspect the partial state before retrying.

Changes to workflows and rulesets are security-sensitive and must be reviewed carefully. Repository-admin permissions are needed to activate rulesets, set the default branch, and configure environments. Verify ruleset availability for your GitHub plan before treating the strategy as enforced.