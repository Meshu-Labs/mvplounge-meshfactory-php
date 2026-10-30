# TK Generated Artifacts Storage and Reporting

This task document defines where generated diagnostic artifacts must be stored and how to generate them consistently.

## Storage Location Policy

- Store generated diagnostic outputs under `/.tmp/` at repository root.
- Do not store generated reports in root-level source folders.
- `/.tmp/` is ignored by git and is treated as ephemeral workspace output.
- Artifacts must be organized by file type under these subfolders:
	- `/.tmp/json/`
	- `/.tmp/txt/`
	- `/.tmp/php/`
	- `/.tmp/tmp/`
- Do not place generated files directly in `/.tmp/` root unless the artifact has no extension.

## Standard Artifact Files

- `/.tmp/txt/attr-scan-report.txt`
- `/.tmp/txt/sandbox-run-latest.txt`
- `/.tmp/json/element-attribute-overlap.json`
- `/.tmp/json/factory-attribute-audit.json`

Use these filenames unless a task explicitly requires a timestamped variant.

## Reference Documents

- Quality execution: `docs/tasks/TK-quality-check-playbook.md`
- Attribute model context: `docs/architecture/AX-attribute-model-and-deductions.md`
- Element-group mapping context: `docs/architecture/AX-element-group-abstract-inventory.md`

## Generation Commands

### Capture Full Sandbox Run Output

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php" |
Out-File -FilePath "c:/_src/app-mvplounge-meshfactory/.tmp/txt/sandbox-run-latest.txt" -Encoding utf8
```

### Attribute-Coverage Scan Report (Template)

```powershell
$out = "c:/_src/app-mvplounge-meshfactory/.tmp/txt/attr-scan-report.txt"

# Replace this block with the active attribute-scan logic for the current iteration.
# Required report structure:
# ONLY_COUNT=<n>
# ONLY=<fqcn>
# OUTSIDE_COUNT=<n>
# OUTSIDE=<fqcn>::<attr-list>

"ONLY_COUNT=0`nOUTSIDE_COUNT=0" | Set-Content -Path $out -Encoding utf8
Write-Host "Wrote $out"
```

## Operational Method

1. Generate report artifacts into the correct `/.tmp/{filetype}/` folder.
2. Review outputs against the reference docs above.
3. Summarize findings in docs when required by task scope.
4. Keep only the latest useful artifacts locally; do not commit them.
