# MeshFactory Source Notes

## Runtime Guard Policy

- `MVPLOUNGE_MESHFACTORY_BASE_PATH` is defined only in `Constants.php`.
- MeshFactory PHP source files require the constant to exist and throw when it is missing:

```php
if (!defined('MVPLOUNGE_MESHFACTORY_BASE_PATH')) {
    throw new \RuntimeException('MVPLOUNGE_MESHFACTORY_BASE_PATH is not defined.');
}
```

## Direct Access Policy

- Subdirectories under `src/MvpLounge` include `.htaccess` and `index.php` files to block direct web execution.

## Output API Policy

- Canonical HTML output method: `compileAsHtmlString(): ?string`
- Canonical structured output method: `compileAsArray(): ?array`
- Canonical headless payload method: `compileAsJson(): ?string`

## HTML Element Domain Organization

- HTML element factories are organized under `Element/Html/{Domain}/`.
- Domain names are sourced from the HTML reference domain headings.
- Domain normalization rules:
    - `Main root` -> `Root`
    - `Document metadata` -> `MetaData`
- Canonical source-of-truth classes are maintained in `Element/Html/{Domain}/`.
- Shared HTML base class remains at:
    - `Element/Html/HtmlElement.php`
- Reserved keyword-safe class naming is used where needed:
    - `object` -> `ObjectElement`
    - `var` -> `VarElement`
