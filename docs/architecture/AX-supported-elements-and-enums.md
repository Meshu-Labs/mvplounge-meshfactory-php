# Supported Elements and Enums

## Supported Elements

Current element support comes from FactoryElement.

- Core text and media: p, h1, h2, h3, h4, h5, h6, hl, img
- Field and form: fieldset, input, select, option, textarea, form
- Link and layout: a, div, span, label, aside, content, header, figure, main, section, article, footer, nav
- Table: th, td, tr, table, thead, tfoot, tbody

## Enum Sources of Truth

- FactoryElement
- FactoryElementAttribute
- FactoryElementFieldType
- FactoryElementPrimativeType

## Usage Guidance

- Use enum values as the canonical compatibility contract.
- Prefer enum-based checks over string literals.
- Introduce new enum values before wiring new attribute behavior.
