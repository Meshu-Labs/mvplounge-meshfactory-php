# Sandbox Factory Tests

Sandbox scripts for MeshFactory are organized by Element domain under `src/MvpLounge/Sandbox/MeshFactory/`.

Each Element domain has three strategy folders:

- Generic
- Factory
- Params

Inside each strategy folder, scripts are class-based and use this naming pattern:

- `{FactoryElementClassName}-sandbox.php`

Examples:

- `src/MvpLounge/Sandbox/MeshFactory/InlineTextSemantics/Factory/Anchor-sandbox.php`
- `src/MvpLounge/Sandbox/MeshFactory/TextContent/Params/Div-sandbox.php`
- `src/MvpLounge/Sandbox/MeshFactory/Root/Generic/Html-sandbox.php`

Strategy contract:

1. Generic: no constructor params, baseline compile/render assertions.
2. Factory: fluent attribute method calls based on allowed attributes, then compile/render assertions.
3. Params: constructor params based on allowed attributes, then compile/render assertions.

Attribute injection rule:

- Params used in sandbox scripts must be scoped to attribute names defined by:
	- `FactoryAbstract::$FactoryElementAttributes`
	- `FactoryElement*::$AllowedFactoryElementAttributes` for the tested class chain

Shared helpers:

- Reusable helper functions live in `src/MvpLounge/Sandbox/MeshFactory/_shared/factory-element-sandbox-shared.php`.
- Per-class scripts keep local assertions and explicit try/catch output while using shared builders for repeatable attribute setup.

Current phased migration note:

- Table, Form, and Field domains are temporarily excluded from this per-class refactor.

Run all MeshFactory sandbox scripts:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"
```
