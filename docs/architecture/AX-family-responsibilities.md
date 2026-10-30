# Family Responsibilities

## Abstract Family Responsibilities

- FactoryAbstract: shared DOM attributes and base collection shape.
- FactoryElementAbstract: element-level behavior and allowed element coordination.
- FactoryElementFieldAbstract family: form input behavior and value typing.
- FactoryElementFieldInputAbstract family: input-specialized field behavior.
- FactoryElementFieldsetAbstract family: fieldset container behavior.
- FactoryElementHtmlAbstract family: generic HTML-domain element behavior.
- Domain abstract families derived from MDN element groups:
	- FactoryElementDemarcatingEditsAbstract
	- FactoryElementEmbeddedContentAbstract
	- FactoryElementFormElementsAbstract
	- FactoryElementImageAndMultimediaAbstract
	- FactoryElementInlineTextSemanticsAbstract
	- FactoryElementInteractiveElementsAbstract
	- FactoryElementMetaDataAbstract
	- FactoryElementObsoleteAndDeprecatedAbstract
	- FactoryElementRootAbstract
	- FactoryElementScriptingAbstract
	- FactoryElementSectioningContentAbstract
	- FactoryElementSvgAndMathMlAbstract
	- FactoryElementTableContentAbstract
	- FactoryElementTextContentAbstract
	- FactoryElementWebComponentsAbstract
- FactoryElementLinkAbstract family: link and anchor behavior.
- FactoryElementTableAbstract family: table structure behavior.
- FactoryElementFormAbstract family: form-wide behavior and child composition.

## Abstraction Depth Contract

- Default abstract depth from FactoryAbstract is capped at two levels.
- Field families are allowed up to four levels due to field-composition complexity.

## Writing Style Expectations

- Keep implementation practical and readable.
- Favor clear logic over clever logic.
- Avoid overengineering.
- Keep array output clean and intentional.

## Current Focus

- Dynamic layer: attributes.
- Stable layer: structure, inheritance, and naming conventions.
