# TK Package and XAMPPIRE Consumption

Runbook for turning the working tree into an installable artifact, and for testing it in the local EELC instance hosted by PS-XAMPPIRE. Commands were run on Windows with PHP 8.2.12 (`C:\xampp_devops_test\php\php.exe`) and Composer 2.11 (`C:\Users\lball\AppData\Roaming\Composer\latest.phar`). Replace paths if yours differ.

Related: [Composer and consumption contract](../architecture/AX-composer-and-consumption.md), backlog stories `EF-070` to `EF-073`.

## Shortcuts Used Below

```powershell
$php = 'C:\xampp_devops_test\php\php.exe'
$composer = 'C:\Users\lball\AppData\Roaming\Composer\latest.phar'
# usage: & $php $composer <command>
```

## 1. Verify Before Packaging

From `C:\_src\app-mvplounge-meshfactory`:

| Step | Command | Pass condition |
|---|---|---|
| Metadata | `& $php $composer validate --strict --no-check-publish` | `./composer.json is valid` |
| Syntax | `Get-ChildItem src,scripts -Recurse -Filter *.php \| ForEach-Object { & $php -l $_.FullName }` | no `Parse error` |
| Sandbox suite | `& $php $composer test` | exit code 0, 333 `PASS assertions`, last line `All sandbox scripts executed.` |
| Inventory | `& $php $composer inventory` | rewrites `docs/architecture/AX-element-factory-inventory.md`; commit the result when classes or sandboxes change |

`composer test` runs `src/Sandbox/MeshFactory/run-all.php`, which uses the PHP that started it (`PHP_BINARY`), so it works the same locally and in CI.

## 2. Build The Artifact

```powershell
& $php scripts\build-artifact.php --version=dev-local --out=C:\_src\ps-xamppire\.tmp\artifacts
# or: & $php $composer artifact -- --version=dev-local --out=C:\_src\ps-xamppire\.tmp\artifacts
```

Output:

```
ARTIFACT C:/_src/ps-xamppire/.tmp/artifacts/mvplounge-meshfactory-dev-local.zip
VERSION  dev-local
ENTRIES  195
SHA256   <hash>
```

What is inside: `composer.json` (with a `version` injected) and everything under `src/Labs/MeshFactory/`. Docs, sandbox, scripts, `.github`, and `vendor` are not packaged. The content list is identical to `composer archive` (195 entries, compared in both directions).

Why a version is injected: Composer's `artifact` repository rejects a zip whose `composer.json` has no `version` (`Package mvplounge/meshfactory has no version defined`). Accepted formats: `dev-<name>` or `X.Y.Z` with an optional `-alpha`, `-beta`, `-RC`, `-dev`, `-patch` suffix.

CI builds the same artifact on every pull request and push to `dev` or `main`: open the workflow run, then **Artifacts**, then `mvplounge-meshfactory-artifact` (kept 14 days). Its version is `dev-ci-<run number>`.

## 3. Consume It

Pick one mode. All three were tried against a scratch consumer except mode C, which is the existing EELC flow.

| Mode | Use when | Constraint to require |
|---|---|---|
| A. `path` repository | Iterating on the working tree; no zip needed | `dev-<branch>` (for example `dev-elementfactory-integration-progress-qc-263010`) |
| B. `artifact` repository | Testing a specific zip (local build or CI download), offline | the version you built (`dev-local`, `dev-ci-42`, `0.9.0-alpha1`) |
| C. GitHub `vcs` / default package | Testing a pushed branch exactly as EELC does today | `dev-<branch>` or `dev-main` |

### Mode A: path repository

```json
{
  "repositories": [
    { "type": "path", "url": "C:/_src/app-mvplounge-meshfactory", "options": { "symlink": false } }
  ],
  "require": { "mvplounge/meshfactory": "dev-elementfactory-integration-progress-qc-263010" }
}
```

`symlink: false` copies files ("Mirroring from ..."), which avoids Windows symlink privilege issues. Re-run `composer update mvplounge/meshfactory` to refresh the copy. The copy reflects the working tree, including uncommitted changes; the version label comes from the checked-out branch.

### Mode B: artifact repository

```json
{
  "minimum-stability": "dev",
  "repositories": [
    { "type": "artifact", "url": "C:/_src/ps-xamppire/.tmp/artifacts" }
  ],
  "require": { "mvplounge/meshfactory": "dev-local" }
}
```

The folder may hold several zips; Composer picks the version you require. Rebuilding the same version needs `composer update mvplounge/meshfactory` and, if Composer cached it, `composer clear-cache`.

### Mode C: GitHub branch

EELC already pulls `mvplounge/meshfactory` as `dev-main` from `Meshu-Labs/mvplounge-meshfactory-php` (dist zipball, `preferred-install: dist`). GitHub builds that zipball with `git archive`, so `.gitattributes` export rules (`composer.json` and `src/Labs/MeshFactory` only) decide its content. To test a pushed branch, require `dev-<branch>`. Per `.github/rulesets`, work lands on `dev` through pull requests and `main` is promoted from `dev`.

## 4. Test In The EELC Instance (XAMPPIRE)

EELC resolves the library from `src/_project/system/user/addons/lab_center/composer.json` (`"mvplounge/meshfactory": "dev-main"`). `vendor/` and `composer.lock` are not tracked in `app-eelc` (`vendor/` is git-ignored), so every environment installs for itself. PS-XAMPPIRE hosts the local instance (`src/platforms/eelc`, module path `wfe/system/user/addons/lab_center`); none of its EELC scripts invoke Composer, so install the package yourself as below.

Use a separate Composer file so the committed `composer.json` stays untouched:

```powershell
cd C:\_src\app-eelc\src\_project\system\user\addons\lab_center
Copy-Item composer.json composer.local.json
# edit composer.local.json: add the repositories block for mode A or B and change the meshfactory constraint
Add-Content C:\_src\app-eelc\.git\info\exclude "src/_project/system/user/addons/lab_center/composer.local.*"

$env:COMPOSER = 'composer.local.json'          # Composer reads this file and writes composer.local.lock
& $php $composer update mvplounge/meshfactory --no-interaction
Remove-Item Env:COMPOSER
```

Verify:

```powershell
# 1. Files arrived
Test-Path vendor\mvplounge\meshfactory\src\Labs\MeshFactory\Abstract\FactoryAbstract.php

# 2. The class autoloads and renders
& $php -r "require 'vendor/autoload.php'; echo (new MvpLounge\MeshFactory\Element\TextContent\P(['content'=>'ok']))->string();"
# expected: <p>ok</p>

# 3. A Form-folder field class resolves through the classmap
& $php -r "require 'vendor/autoload.php'; echo class_exists(MvpLounge\MeshFactory\Element\Field\InputText::class) ? 'yes' : 'no';"
```

Then load the EELC page that uses the facade you changed and compare rendered HTML with the previous build, as the migration checklist in `AG-app-eelc-referential-instructions.md` requires.

To return to the committed pin:

```powershell
Remove-Item vendor\mvplounge -Recurse -Force
& $php $composer install --no-interaction      # uses composer.json as before
```

## 5. Release (when stable)

1. Merge to `dev`, then promote to `main` through the reviewed PR.
2. Run the **Publish** workflow on `main` with a new tag (`vX.Y.Z`). Only approved accounts may run it; tags cannot be reused. It creates the release and notifies Packagist.
3. Change EELC's constraint from `dev-main` to a semantic version (`EF-072`). Ship class renames (`EF-040`, `EF-042`) only in a major version with deprecation aliases.

## 6. Troubleshooting

| Symptom | Cause | Fix |
|---|---|---|
| `Package mvplounge/meshfactory has no version defined` | Zip built without a `version` (for example plain `composer archive`) | Build with `scripts/build-artifact.php` |
| `Your requirements could not be resolved` with an artifact | The constraint does not match the version in the zip | Require the exact version string you built (`dev-local`, `dev-ci-42`) |
| Old code after rebuilding the same version | Composer cache or lock | `composer clear-cache`, then `composer update mvplounge/meshfactory` |
| `Class "MvpLounge\MeshFactory\Element\Field\InputText" not found` | Autoloader built without the classmap | `composer dump-autoload`; the Field classes live in `Element/Form/` (`EF-040`) |
| `composer test` fails with `Composer autoload not found` | `vendor/` missing | `composer install` once in the repository |
| Windows symlink error in mode A | Missing privilege | keep `"symlink": false` |

## Not Yet Verified

- A Linux run of `composer test` (the CI runner). The Docker daemon was not running locally; an include-path case check of all 1,043 `require_once __DIR__` targets found no case mismatches. `EF-071` tracks the first CI run.
- Mode C against a freshly pushed branch.
- Section 4 inside the real `lab_center` folder. The same Composer behavior was verified in scratch consumers (modes A and B); the live EELC `vendor/` was not modified.
