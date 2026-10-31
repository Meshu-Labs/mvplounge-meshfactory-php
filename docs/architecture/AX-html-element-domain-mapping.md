# AX HTML Element Domain Mapping

This document maps HTML element domains (MDN element groups) to MeshFactory folders, namespaces, and abstract parents. The per-element rows (every enum element, its class, tier, tests, and TypeScript counterpart) are generated in [AX-element-factory-inventory.md](AX-element-factory-inventory.md); do not duplicate them here.

## Domain Normalization Rules

- Main root becomes `Root`.
- Document metadata becomes `MetaData`.
- Forms and the field classes live in `Form` (field classes keep the `Element\Field` namespace, see `EF-040`).

## Namespace Root

Canonical classes resolve under `MvpLounge\MeshFactory\Element\{Domain}\{Class}` and live in `src/Labs/MeshFactory/Element/{Domain}/{Class}.php`. There is no `Element\Html` namespace and no shared `HtmlElement` base: plain elements extend `MvpLounge\MeshFactory\Abstract\FactoryElementHtmlAbstract`. Reserved-keyword tags keep safe class names: `object` is `ObjectElement`, `var` is `VarElement`.

## Domains

| Domain | Namespace | Abstract parent | Classes |
|---|---|---|---:|
| DemarcatingEdits | `...\Element\DemarcatingEdits` | `FactoryElementHtmlAbstract` | 2 |
| EmbeddedContent | `...\Element\EmbeddedContent` | `FactoryElementEmbeddedContentAbstract` | 7 |
| Form | `...\Element\Form` and `...\Element\Field` | `FactoryElementFormElementsAbstract`, `FactoryElementFormAbstract`, `FactoryElementFieldAbstract`, `FactoryElementFieldInputAbstract` | 18 |
| ImageAndMultimedia | `...\Element\ImageAndMultimedia` | `FactoryElementImageAndMultimediaAbstract` | 7 |
| InlineTextSemantics | `...\Element\InlineTextSemantics` | `FactoryElementHtmlAbstract`, `FactoryElementLinkAbstract` (`Anchor`) | 32 |
| InteractiveElements | `...\Element\InteractiveElements` | `FactoryElementHtmlAbstract` | 3 |
| MetaData | `...\Element\MetaData` | `FactoryElementMetaDataAbstract` | 5 |
| ObsoleteAndDeprecated | `...\Element\ObsoleteAndDeprecated` | `FactoryElementHtmlAbstract` | 16 |
| Root | `...\Element\Root` | `FactoryElementHtmlAbstract` | 3 |
| Scripting | `...\Element\Scripting` | `FactoryElementScriptingAbstract` | 3 |
| SectioningContent | `...\Element\SectioningContent` | `FactoryElementHtmlAbstract` | 8 |
| SvgAndMathMl | `...\Element\SvgAndMathMl` | `FactoryElementHtmlAbstract` | 2 |
| Table | `...\Element\Table` | `FactoryElementTableAbstract` | 8 |
| TableContent | `...\Element\TableContent` | `FactoryElementHtmlAbstract` | 3 |
| TextContent | `...\Element\TextContent` | `FactoryElementHtmlAbstract` | 22 |
| WebComponents | `...\Element\WebComponents` | `FactoryElementHtmlAbstract` | 4 |

`...` stands for `MvpLounge\MeshFactory`. The `Links` folder exists but holds no classes: `Anchor` lives in `InlineTextSemantics`.

## APP-EELC Core Element Routing

| Enum | Canonical Class | Domain |
|---|---|---|
| `FactoryElement::P` | `MvpLounge\MeshFactory\Element\TextContent\P` | `TextContent` |
| `FactoryElement::H1` | `MvpLounge\MeshFactory\Element\TextContent\H1` | `TextContent` |
| `FactoryElement::H2` | `MvpLounge\MeshFactory\Element\TextContent\H2` | `TextContent` |
| `FactoryElement::H3` | `MvpLounge\MeshFactory\Element\TextContent\H3` | `TextContent` |
| `FactoryElement::H4` | `MvpLounge\MeshFactory\Element\TextContent\H4` | `TextContent` |
| `FactoryElement::H5` | `MvpLounge\MeshFactory\Element\TextContent\H5` | `TextContent` |
| `FactoryElement::H6` | `MvpLounge\MeshFactory\Element\TextContent\H6` | `TextContent` |
| `FactoryElement::HL` | `MvpLounge\MeshFactory\Element\TextContent\Hl` | `TextContent` |
| `FactoryElement::IMG` | `MvpLounge\MeshFactory\Element\ImageAndMultimedia\Img` | `ImageAndMultimedia` |
| `FactoryElement::DIV` | `MvpLounge\MeshFactory\Element\TextContent\Div` | `TextContent` |
| `FactoryElement::SPAN` | `MvpLounge\MeshFactory\Element\InlineTextSemantics\Span` | `InlineTextSemantics` |
| `FactoryElement::ANCHOR` | `MvpLounge\MeshFactory\Element\InlineTextSemantics\Anchor` | `InlineTextSemantics` |
| `FactoryElement::LABEL` | `MvpLounge\MeshFactory\Element\Form\FieldsetLabel` | `Form` |
| `FactoryElement::ASIDE` | `MvpLounge\MeshFactory\Element\SectioningContent\Aside` | `SectioningContent` |
| `FactoryElement::CONTENT` | `MvpLounge\MeshFactory\Element\WebComponents\Content` | `WebComponents` |
| `FactoryElement::HEADER` | `MvpLounge\MeshFactory\Element\SectioningContent\Header` | `SectioningContent` |
| `FactoryElement::FIGURE` | `MvpLounge\MeshFactory\Element\TextContent\Figure` | `TextContent` |
| `FactoryElement::MAIN` | `MvpLounge\MeshFactory\Element\TextContent\Main` | `TextContent` |
| `FactoryElement::SECTION` | `MvpLounge\MeshFactory\Element\SectioningContent\Section` | `SectioningContent` |
| `FactoryElement::ARTICLE` | `MvpLounge\MeshFactory\Element\SectioningContent\Article` | `SectioningContent` |
| `FactoryElement::FOOTER` | `MvpLounge\MeshFactory\Element\SectioningContent\Footer` | `SectioningContent` |
| `FactoryElement::NAV` | `MvpLounge\MeshFactory\Element\SectioningContent\Nav` | `SectioningContent` |
