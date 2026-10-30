# MeshFactory Form and Table Use Cases

This note captures the sandbox examples added for common form and table scenarios.

## Form Use Cases

The form sandbox now demonstrates these scenarios under `src/MvpLounge/Sandbox/MeshFactory/Form/`:

- Login form for an existing account sign-in flow.
- Registration form for a basic user account signup flow.
- Address form for profile shipping or billing address maintenance.
- Profile update form using the Ajax form variation.

Each example exercises the supported form attributes:

- `action`
- `method`
- `enctype`
- `novalidate`
- `target`
- `autocomplete`
- Global attributes such as `id`, `class`, `title`, `style`, `lang`, `dir`, `hidden`, `tabindex`, `draggable`, `contenteditable`, `spellcheck`, `translate`, `role`, and ARIA labels

## Table Use Cases

The table sandbox now demonstrates these scenarios under `src/MvpLounge/Sandbox/MeshFactory/Table/`:

- A 4-column summary table for dashboard-style reporting.
- A merged cell example with `colspan` and `rowspan`.
- A grouped header example with `scope`, `headers`, and `abbr`.
- A data table body example that reuses the 4-column layout with different content.

Each example exercises the supported table attributes:

- `border`
- `cellspacing`
- `cellpadding`
- `colspan`
- `rowspan`
- `scope`
- `headers`
- `abbr`
- Global attributes such as `id`, `class`, `title`, `style`, `lang`, `dir`, `hidden`, `tabindex`, `draggable`, `contenteditable`, `spellcheck`, `translate`, `role`, and ARIA labels

## Sandbox Runner

Run the full MeshFactory sandbox suite with:

```powershell
& "C:/xampp_devops_test/php/php.exe" "c:/_src/app-mvplounge-meshfactory/src/MvpLounge/Sandbox/MeshFactory/run-all.php"
```
