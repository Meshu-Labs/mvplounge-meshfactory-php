# Factory Naming and Inheritance

## Naming Convention

Base abstract classes follow:

- FactoryElement{DomDomain}Abstract
- FactoryAbstract for shared root behavior

Examples:

- FactoryElementTableAbstract
- FactoryElementFormAbstract
- FactoryElementFieldAbstract
- FactoryElementHtml5Abstract
- FactoryElementLinkAbstract

## Namespace Organization

All abstract factory base classes belong in:

- MvpLounge\\MeshFactory\\Abstract

## Inheritance Intent

- Shared logic belongs in the nearest valid base class.
- Concrete classes should remain small and direct.
- Prefer inheritance over repeated conditional logic.

## Structural Preservation Rules

- Keep shape deductive: enum, element, base class, concrete class.
- Do not introduce parallel or duplicated abstraction paths.
- Keep arrays flat unless nested structure is required by data shape.
