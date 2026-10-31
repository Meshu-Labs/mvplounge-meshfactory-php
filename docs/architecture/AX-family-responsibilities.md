# Family Responsibilities

## Abstract Family Responsibilities

- FactoryAbstract: shared DOM attributes and base collection shape.
- FactoryElementAbstract: element-level behavior and allowed element coordination.
- FactoryElementHtmlAbstract: plain elements with global attributes only (99 subclasses).
- FactoryElementFieldAbstract family: form input behavior and value typing.
- FactoryElementLinkAbstract family: link and anchor behavior.
- FactoryElementTableAbstract family: table structure behavior.
- FactoryElementFormAbstract family: form-wide behavior and child composition.
- FactoryElementImageAndMultimediaAbstract, FactoryElementEmbeddedContentAbstract, FactoryElementMetaDataAbstract, FactoryElementScriptingAbstract: element-family attribute sets.
- FactoryElementFormElementsAbstract: form-associated elements (`label`, `button`, `meter`, and similar).
- Unused today (`EF-041`): FactoryElementHtml5Abstract and FactoryElementCopyAbstract have no subclasses.

Method-level detail: [API reference](AX-element-factory-api-reference.md).

## Writing Style Expectations

- Keep implementation practical and readable.
- Favor clear logic over clever logic.
- Avoid overengineering.
- Keep array output clean and intentional.

## Current Focus

- Dynamic layer: attributes.
- Stable layer: structure, inheritance, and naming conventions.
