# AX HTML Element Domain Mapping

This document maps source-of-truth HTML element domains to MeshFactory class namespaces and class names.

## Domain Normalization Rules

- Main root -> Root
- Document metadata -> MetaData

## Current Namespace Root

- Canonical classes currently resolve under `MvpLounge\\MeshFactory\\Element\\{Domain}\\{Class}`.

## APP-EELC Core Element Routing

| Enum | Canonical Class | Domain |
|---|---|---|
| `FactoryElement::P` | `MvpLounge\\MeshFactory\\Element\\TextContent\\P` | `TextContent` |
| `FactoryElement::H1` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H1` | `TextContent` |
| `FactoryElement::H2` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H2` | `TextContent` |
| `FactoryElement::H3` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H3` | `TextContent` |
| `FactoryElement::H4` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H4` | `TextContent` |
| `FactoryElement::H5` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H5` | `TextContent` |
| `FactoryElement::H6` | `MvpLounge\\MeshFactory\\Element\\TextContent\\H6` | `TextContent` |
| `FactoryElement::HL` | `MvpLounge\\MeshFactory\\Element\\TextContent\\Hl` | `TextContent` |
| `FactoryElement::IMG` | `MvpLounge\\MeshFactory\\Element\\ImageAndMultimedia\\Img` | `ImageAndMultimedia` |
| `FactoryElement::DIV` | `MvpLounge\\MeshFactory\\Element\\TextContent\\Div` | `TextContent` |
| `FactoryElement::SPAN` | `MvpLounge\\MeshFactory\\Element\\InlineTextSemantics\\Span` | `InlineTextSemantics` |
| `FactoryElement::LABEL` | `MvpLounge\\MeshFactory\\Element\\Form\\Label` | `Form` |
| `FactoryElement::ASIDE` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Aside` | `SectioningContent` |
| `FactoryElement::CONTENT` | `MvpLounge\\MeshFactory\\Element\\WebComponents\\Content` | `WebComponents` |
| `FactoryElement::HEADER` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Header` | `SectioningContent` |
| `FactoryElement::FIGURE` | `MvpLounge\\MeshFactory\\Element\\TextContent\\Figure` | `TextContent` |
| `FactoryElement::MAIN` | `MvpLounge\\MeshFactory\\Element\\TextContent\\Main` | `TextContent` |
| `FactoryElement::SECTION` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Section` | `SectioningContent` |
| `FactoryElement::ARTICLE` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Article` | `SectioningContent` |
| `FactoryElement::FOOTER` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Footer` | `SectioningContent` |
| `FactoryElement::NAV` | `MvpLounge\\MeshFactory\\Element\\SectioningContent\\Nav` | `SectioningContent` |

## Mapping

| Source Domain | Library Domain Namespace | Source Element | Library Class | Notes |
|---|---|---|---|---|
| Demarcating edits | MvpLounge\\MeshFactory\\Element\\Html\\DemarcatingEdits | del | MvpLounge\\MeshFactory\\Element\\Html\\DemarcatingEdits\\Del |  |
| Demarcating edits | MvpLounge\\MeshFactory\\Element\\Html\\DemarcatingEdits | ins | MvpLounge\\MeshFactory\\Element\\Html\\DemarcatingEdits\\Ins |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | embed | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Embed |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | fencedframe | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Fencedframe |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | iframe | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Iframe |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | object | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\ObjectElement | Reserved keyword class-name safeguard |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | param | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Param |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | picture | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Picture |  |
| Embedded content | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent | source | MvpLounge\\MeshFactory\\Element\\Html\\EmbeddedContent\\Source |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | button | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Button |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | datalist | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Datalist |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | label | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Label |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | legend | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Legend |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | meter | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Meter |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | optgroup | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Optgroup |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | output | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Output |  |
| Forms | MvpLounge\\MeshFactory\\Element\\Html\\Forms | progress | MvpLounge\\MeshFactory\\Element\\Html\\Forms\\Progress |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | area | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Area |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | audio | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Audio |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | image | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Image |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | map | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Map |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | track | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Track |  |
| Image and multimedia | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia | video | MvpLounge\\MeshFactory\\Element\\Html\\ImageAndMultimedia\\Video |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | abbr | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Abbr |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | acronym | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Acronym |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | a | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Anchor | Source element a mapped to Anchor class |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | b | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\B |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | bdi | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Bdi |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | bdo | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Bdo |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | big | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Big |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | br | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Br |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | cite | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Cite |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | code | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Code |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | data | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Data |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | dfn | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Dfn |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | em | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Em |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | i | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\I |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | kbd | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Kbd |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | mark | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Mark |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | q | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Q |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | rp | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Rp |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | rt | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Rt |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | ruby | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Ruby |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | s | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\S |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | samp | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Samp |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | small | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Small |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | span | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Span |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | strong | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Strong |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | sub | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Sub |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | sup | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Sup |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | time | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Time |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | tt | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Tt |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | u | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\U |  |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | var | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\VarElement | Reserved keyword class-name safeguard |
| Inline text semantics | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics | wbr | MvpLounge\\MeshFactory\\Element\\Html\\InlineTextSemantics\\Wbr |  |
| Interactive elements | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements | details | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements\\Details |  |
| Interactive elements | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements | dialog | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements\\Dialog |  |
| Interactive elements | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements | summary | MvpLounge\\MeshFactory\\Element\\Html\\InteractiveElements\\Summary |  |
| Document metadata (normalized to MetaData) | MvpLounge\\MeshFactory\\Element\\Html\\MetaData | base | MvpLounge\\MeshFactory\\Element\\Html\\MetaData\\Base |  |
| Document metadata (normalized to MetaData) | MvpLounge\\MeshFactory\\Element\\Html\\MetaData | link | MvpLounge\\MeshFactory\\Element\\Html\\MetaData\\Link |  |
| Document metadata (normalized to MetaData) | MvpLounge\\MeshFactory\\Element\\Html\\MetaData | meta | MvpLounge\\MeshFactory\\Element\\Html\\MetaData\\Meta |  |
| Document metadata (normalized to MetaData) | MvpLounge\\MeshFactory\\Element\\Html\\MetaData | style | MvpLounge\\MeshFactory\\Element\\Html\\MetaData\\Style |  |
| Document metadata (normalized to MetaData) | MvpLounge\\MeshFactory\\Element\\Html\\MetaData | title | MvpLounge\\MeshFactory\\Element\\Html\\MetaData\\Title |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | center | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Center |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | dir | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Dir |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | font | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Font |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | frame | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Frame |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | frameset | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Frameset |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | geolocation | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Geolocation |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | marquee | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Marquee |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | menuitem | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Menuitem |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | nobr | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Nobr |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | noembed | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Noembed |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | noframes | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Noframes |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | plaintext | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Plaintext |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | rb | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Rb |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | rtc | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Rtc |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | strike | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Strike |  |
| Obsolete and deprecated elements | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated | xmp | MvpLounge\\MeshFactory\\Element\\Html\\ObsoleteAndDeprecated\\Xmp |  |
| Main root (simplified to Root) | MvpLounge\\MeshFactory\\Element\\Html\\Root | body | MvpLounge\\MeshFactory\\Element\\Html\\Root\\Body |  |
| Main root (simplified to Root) | MvpLounge\\MeshFactory\\Element\\Html\\Root | head | MvpLounge\\MeshFactory\\Element\\Html\\Root\\Head |  |
| Main root (simplified to Root) | MvpLounge\\MeshFactory\\Element\\Html\\Root | html | MvpLounge\\MeshFactory\\Element\\Html\\Root\\Html |  |
| Scripting | MvpLounge\\MeshFactory\\Element\\Html\\Scripting | canvas | MvpLounge\\MeshFactory\\Element\\Html\\Scripting\\Canvas |  |
| Scripting | MvpLounge\\MeshFactory\\Element\\Html\\Scripting | noscript | MvpLounge\\MeshFactory\\Element\\Html\\Scripting\\Noscript |  |
| Scripting | MvpLounge\\MeshFactory\\Element\\Html\\Scripting | script | MvpLounge\\MeshFactory\\Element\\Html\\Scripting\\Script |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | address | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Address |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | article | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Article |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | aside | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Aside |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | footer | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Footer |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | header | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Header |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | nav | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Nav |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | search | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Search |  |
| Content sectioning | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent | section | MvpLounge\\MeshFactory\\Element\\Html\\SectioningContent\\Section |  |
| SVG and MathML | MvpLounge\\MeshFactory\\Element\\Html\\SvgAndMathMl | math | MvpLounge\\MeshFactory\\Element\\Html\\SvgAndMathMl\\Math |  |
| SVG and MathML | MvpLounge\\MeshFactory\\Element\\Html\\SvgAndMathMl | svg | MvpLounge\\MeshFactory\\Element\\Html\\SvgAndMathMl\\Svg |  |
| Table content | MvpLounge\\MeshFactory\\Element\\Html\\TableContent | caption | MvpLounge\\MeshFactory\\Element\\Html\\TableContent\\Caption |  |
| Table content | MvpLounge\\MeshFactory\\Element\\Html\\TableContent | col | MvpLounge\\MeshFactory\\Element\\Html\\TableContent\\Col |  |
| Table content | MvpLounge\\MeshFactory\\Element\\Html\\TableContent | colgroup | MvpLounge\\MeshFactory\\Element\\Html\\TableContent\\Colgroup |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | blockquote | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Blockquote |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | dd | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Dd |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | div | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Div |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | dl | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Dl |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | dt | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Dt |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | figcaption | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Figcaption |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | figure | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Figure |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | hr | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Hr |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | li | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Li |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | main | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Main |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | menu | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Menu |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | ol | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Ol |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | pre | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Pre |  |
| Text content | MvpLounge\\MeshFactory\\Element\\Html\\TextContent | ul | MvpLounge\\MeshFactory\\Element\\Html\\TextContent\\Ul |  |
| Web Components | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents | content | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents\\Content |  |
| Web Components | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents | selectedcontent | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents\\Selectedcontent |  |
| Web Components | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents | shadow | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents\\Shadow |  |
| Web Components | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents | template | MvpLounge\\MeshFactory\\Element\\Html\\WebComponents\\Template |  |

## Canonical Import Rule

- Import and instantiate classes from `Element/{Domain}` only.
- Do not use `Element/Html5/*` or `Element/Links/Anchor` for new or existing integrations.

## Base Class

- Shared HTML behavior base class: `MvpLounge\\MeshFactory\\Abstract\\FactoryElementHtmlAbstract` in `src/MvpLounge/MeshFactory/Abstract/FactoryElementHtmlAbstract.php`.