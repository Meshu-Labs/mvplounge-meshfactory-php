# AX Element Group Abstract Inventory

This inventory maps concrete Element domains to their abstract parent layer using MDN element-group boundaries as the source-of-truth model.

## Source of Truth

- MDN Elements reference: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements
- MeshFactory enum contracts:
  - `src/MvpLounge/MeshFactory/Enum/FactoryElement.php`
  - `src/MvpLounge/MeshFactory/Enum/FactoryElementAttribute.php`

## Inventory (Post-Prune)

| Element Domain | Primary Abstract Parent | Concrete Count | Notes |
|---|---|---:|---|
| DemarcatingEdits | FactoryElementHtmlAbstract | 2 | No domain-specific attributes currently modeled |
| EmbeddedContent | FactoryElementEmbeddedContentAbstract | 7 | Resource/embed orientation |
| Form | FactoryElementFormElementsAbstract, FactoryElementFormAbstract | 10 | Form shell and form-associated elements |
| Field | FactoryElementFieldAbstract, FactoryElementFieldInputAbstract | 8 | Field family remains exception-depth chain |
| ImageAndMultimedia | FactoryElementImageAndMultimediaAbstract | 6 | Media/image orientation |
| InlineTextSemantics | FactoryElementHtmlAbstract, FactoryElementLinkAbstract | 32 | `Anchor` remains link-specialized |
| InteractiveElements | FactoryElementHtmlAbstract | 3 | No domain-specific attributes currently modeled |
| MetaData | FactoryElementMetaDataAbstract | 5 | Metadata and head-resource families |
| ObsoleteAndDeprecated | FactoryElementHtmlAbstract | 16 | No domain-specific attributes currently modeled |
| Root | FactoryElementHtmlAbstract | 3 | html/head/body roots |
| Scripting | FactoryElementScriptingAbstract | 3 | script/canvas/noscript group |
| SectioningContent | FactoryElementHtmlAbstract | 8 | No domain-specific attributes currently modeled |
| SvgAndMathMl | FactoryElementHtmlAbstract | 2 | Non-HTML XML namespaces |
| Table | FactoryElementTableAbstract | 8 | Existing table specialization retained |
| TableContent | FactoryElementHtmlAbstract | 3 | No domain-specific attributes currently modeled |
| TextContent | FactoryElementHtmlAbstract | 14 | No domain-specific attributes currently modeled |
| WebComponents | FactoryElementHtmlAbstract | 4 | No domain-specific attributes currently modeled |

## Retained Attribute-Introducing Abstract Layer

- `FactoryElementEmbeddedContentAbstract`
- `FactoryElementFormElementsAbstract`
- `FactoryElementImageAndMultimediaAbstract`
- `FactoryElementMetaDataAbstract`
- `FactoryElementScriptingAbstract`

Non-attribute-introducing domain abstracts were intentionally removed, and their concrete elements now inherit from `FactoryElementHtmlAbstract` unless they require an existing specialized family (for example, `InlineTextSemantics\Anchor` inheriting from `FactoryElementLinkAbstract`).

## Validation Method

1. Build inventory from code declarations:
   - Parse `class ... extends ...` across `src/MvpLounge/MeshFactory/Element/`.
2. Compare groups against MDN category intent:
   - Validate each concrete class sits under a matching domain abstract.
3. Validate library integrity:
   - `php -l` for all `src/MvpLounge/MeshFactory/Abstract/*.php`
   - `php -l` for all `src/MvpLounge/MeshFactory/Element/**/*.php`
4. Validate runtime behavior:
   - Run `src/MvpLounge/Sandbox/MeshFactory/run-all.php`
   - Required terminal marker: `All sandbox scripts executed.`

## Follow-Up Refinement Track

This migration corrects domain-level inheritance shape. Attribute-level parity with MDN should continue iteratively by:

- Expanding `FactoryElementAttribute` enum coverage where missing.
- Refining `AllowedFactoryElementAttributes` in domain abstracts as enum coverage grows.
- Promoting recurring leaf-level attribute patterns into intermediate `FactoryElement*Abstract` families.
