# Sandbox Test Realms

The `src/MvpLounge/Sandbox/` directory is the container for library-specific sandbox suites.

Current library suites:

- `MeshFactory/`

Each library suite owns its own:

- `bootstrap.php`
- `run-all.php`
- domain folders such as `Field/`, `Form/`, `Html/`, `Links/`, and `Table/`

MeshFactory domain suites are organized by test type inside each domain:

- `Generic/`
- `Factory/`
- `Params/`

Run the MeshFactory sandbox suite directly:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"
```

Run every library sandbox suite discovered under `src/MvpLounge/Sandbox/`:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/run-all.php"
```
