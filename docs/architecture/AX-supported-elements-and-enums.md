# Supported Elements and Enums

The enums are the compatibility contract. This page summarizes them; the exact per-element status lives in the generated [ElementFactory inventory](AX-element-factory-inventory.md).

## Counts

| Enum | Cases | Source |
|---|---:|---|
| `FactoryElement` | 140 | `src/Labs/MeshFactory/Enum/FactoryElement.php` |
| `FactoryElementAttribute` | 75 | `src/Labs/MeshFactory/Enum/FactoryElementAttribute.php` |
| `FactoryElementFieldType` | 7 | `text`, `email`, `password`, `hidden`, `radio`, `button`, `submit` |
| `FactoryElementPrimativeType` | 4 | `int`, `bool`, `string`, `float` |
| `FactoryElementWindowTarget` | 4 | `_self`, `_blank`, `_parent`, `_top` |

## Element Coverage

- 144 concrete classes in 16 domains under `src/Labs/MeshFactory/Element/` bind 137 of the 140 enum elements.
- 3 enum elements have no class under `Element/`: `hgroup`, `textarea`, `slot` (`EF-020`, `EF-022`). `fieldset` is implemented by `Element/Form/Fieldset` (`EF-047`).
- Several elements have more than one class: `input` (6 field classes), `table` (`TableBody`, `DataTableBody`), and `form` (`FormPost`, `FormAjax`).

Domains: DemarcatingEdits, EmbeddedContent, Form, ImageAndMultimedia, InlineTextSemantics, InteractiveElements, MetaData, ObsoleteAndDeprecated, Root, Scripting, SectioningContent, SvgAndMathMl, Table, TableContent, TextContent, WebComponents. The `Form` folder also holds the field classes, whose namespace is `Element\Field` (`EF-040`).

## Usage Guidance

- Use enum values as the canonical compatibility contract.
- Prefer enum-based checks over string literals.
- Introduce new enum values before wiring new attribute behavior.
- Regenerate counts and per-element status with `composer inventory` instead of editing numbers by hand.
