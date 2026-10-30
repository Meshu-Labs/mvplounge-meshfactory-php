# Factory Naming and Inheritance

## Naming Convention

Base abstract classes follow:

- FactoryElement{DomDomain}Abstract
- FactoryAbstract for shared root behavior

Examples:

- FactoryElementTableAbstract
- FactoryElementFormAbstract
- FactoryElementFieldAbstract
- FactoryElementFieldInputAbstract
- FactoryElementHtmlAbstract
- FactoryElementLinkAbstract
- FactoryElementMetaDataAbstract
- FactoryElementTextContentAbstract
- FactoryElementEmbeddedContentAbstract

Domain-level abstract assignment is tracked in:

- `docs/architecture/AX-element-group-abstract-inventory.md`

## Namespace Organization

All abstract factory base classes belong in:

- MvpLounge\\MeshFactory\\Abstract

## Inheritance Intent

- Shared logic belongs in the nearest valid base class.
- Concrete classes should remain small and direct.
- Prefer inheritance over repeated conditional logic.

## Abstraction Depth Rule

- Default: maximum of two abstract levels from FactoryAbstract.
- Field exception: up to four abstract levels from FactoryAbstract.

## Structural Preservation Rules

- Keep shape deductive: enum, element, base class, concrete class.
- Do not introduce parallel or duplicated abstraction paths.
- Keep arrays flat unless nested structure is required by data shape.
