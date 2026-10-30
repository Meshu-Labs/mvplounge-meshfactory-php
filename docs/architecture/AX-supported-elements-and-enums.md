# Supported Elements and Enums

## Supported Elements

Current element support comes from `FactoryElement` and is validated against the MDN HTML element reference:

- https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements

- Core text and media: p, h1, h2, h3, h4, h5, h6, hl, hgroup, img
- Field and form: fieldset, input, select, option, textarea, form
- Link and layout: a, div, span, label, aside, content, slot, header, figure, main, section, article, footer, nav
- Table: th, td, tr, table, thead, tfoot, tbody

## Standards Notes

- `hgroup` is represented by `FactoryElement::HGROUP`.
- `slot` is represented by `FactoryElement::SLOT`.
- `content` is retained as a legacy enum value for backward compatibility, but MDN classifies the `<content>` element as obsolete and deprecated. New work should prefer the MDN-documented `<slot>` model.

## Enum Sources of Truth

- FactoryElement
- FactoryElementAttribute
- FactoryElementWindowTarget
- FactoryElementFieldType
- FactoryElementPrimativeType

## Usage Guidance

- Use enum values as the canonical compatibility contract.
- Use MDN element and attribute reference pages as the descriptive source of truth for documentation and annotations.
- Prefer enum-based checks over string literals.
- Introduce new enum values before wiring new attribute behavior.
