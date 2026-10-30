# Sandbox Factory Tests

This folder contains one sandbox PHP script per concrete element class under `src/MvpLounge/MeshFactory/Element`.

## Run all

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/Sandbox/run-all.php"
```

## Notes

- Each script constructs a factory class with default params.
- Each script attempts `getFactoryModel()`, `compile()`, and `string()` when available.
- Errors are printed with stack traces for fast debugging.
