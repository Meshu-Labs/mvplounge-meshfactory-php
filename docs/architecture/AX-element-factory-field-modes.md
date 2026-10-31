# AX ElementFactory Field Modes: Wrapped And Raw

This document records the standard for field output in the ElementFactory (`FactoryElementFieldAbstract` and every field type under it). It is the PHP side of the "Form Input Part" that the TypeScript library (`C:\_src\app-mesh-ui`) renders in Storybook.

Related documents: [Pattern](AX-element-factory-pattern.md), [API reference](AX-element-factory-api-reference.md), [TypeScript alignment](AX-element-factory-typescript-alignment.md), [Backlog `EF-066`](../behavior/BV-element-factory-implementation-backlog.md).

## Intent

The ElementFactory is the vanilla, type-based HTML library behind the EELC, MSWP, DISPATCH, and Sitecore AI projects. Each project customizes it on top of one shared baseline. The baseline is synthesized from years of hand-written markup: the same ideas and patterns exist in every project but are implemented differently. The reference for "what a field looks like" is the atomized TypeScript part as shown in Storybook (`Foundation/Part/Form/Fieldset/Raw` and `Wrapped`), plus the HTML the PHP fluent methods can generate.

A factory element therefore represents a **Form Input Part**, and each field has two modes.

| Mode | Meaning | Methods |
|---|---|---|
| **Wrapped** (default) | The full part: field wrapper, label block, inner wrapper, control. Matches the TypeScript `UI_*WrappedField` parts. | `compileAsHtmlString()`, `string()`, `build()`, `compileAsHtmlStringWithFieldset()`, `buildWithFieldset()` |
| **Raw** (unwrapped) | The vanilla control with an optional bare `<label>` carrying the label text only. No wrapper divs, no tooltip. | `compileAsHtmlStringUnwrapped()`, `compileAsHtmlStringUnwrappedWithFieldset()`, `buildUnwrapped()`, `buildUnwrappedWithFieldset()` |

Wrapped is the default behind every `build` and `compile` method. Choose raw only when a view needs the bare control.

### Decisions (confirmed by the project owner)

| Topic | Decision |
|---|---|
| Field wrapper | Applied by default to every field except hidden fields (below). |
| Label and tooltip | Render only when added. The tooltip is the *label explanation or description text*. Raw fields render the label text alone, never the tooltip. |
| Password | Wrapper token `pw`. |
| Hidden | Bare by default (`compileAsHtmlString()`, `string()`, `build()`), because UI code and layout scripts select hidden inputs directly. A hidden field takes the wrapped structure only when rendered with a fieldset (`compileAsHtmlStringWithFieldset()`, `buildWithFieldset()`) that mixes hidden and visible fields. Storybook's wrapped hidden field does not by itself justify wrapping. |
| Radios | Best practice set here: explicit association (`<label for="id">` with a matching `id` on the input) and implicit association (the input nested in the label). Downstream projects add any extra wrapping. |

## Wrapped DOM Contract

Reference (Storybook, a text field with a label and tooltip, in a `fieldset`):

```html
<div class="field-wrapper text" data-field="sample_text_field">
  <label>
    <div class="field-inner-label-wrapper">
      <span class="fld-label-header">Text Field</span>
      <span class="fld-label-tooltip">The quick brown fox</span>
      <div class="clear"></div>
    </div>
    <div class="field-inner-wrapper">
      <input class="field_ui" name="sample_text_field" type="text">
      <div class="clear"></div>
    </div>
  </label>
  <div class="clear"></div>
</div>
```

PHP:

```php
$field = (new InputText())
    ->addName('sample_text_field')
    ->addLabel('Text Field')
    ->addTooltip('The quick brown fox');

echo $field->compileAsHtmlString();      // wrapped (default)
echo $field->compileAsHtmlStringUnwrapped(); // <label>Text Field<input ...></label>
```

Raw output of the same field:

```html
<label>Text Field<input class="field_ui" name="sample_text_field" type="text"></label>
```

## Pipeline

`FactoryElementFieldAbstract` composes the wrapped output from overridable pieces. Subclasses override the **control hook**, not the compile and build methods.

| Step | Getter | Echo |
|---|---|---|
| Field wrapper open | `getElementFieldWrapperOpen()` | `buildFieldWrapperOpen()` |
| Label open (`<label>` plus label block) | `getElementFieldLabelOpen()` | `buildElementFieldLabelOpen()` |
| Inner wrapper open | `getElementFieldInnerWrapperOpen()` | `buildFieldInnerWrapperOpen()` |
| Control | `getElementFieldControl()` | `buildElementFieldControl()` |
| Inner wrapper close (with `clear`) | `getElementFieldInnerWrapperClose()` | `buildFieldInnerWrapperClose()` |
| Label close | `getElementFieldLabelClose()` | `buildElementFieldLabelClose()` |
| Field wrapper close (with `clear`) | `getElementFieldWrapperClose()` | `buildFieldWrapperClose()` |

`getElementFieldLabelWrapper()` returns only the `div.field-inner-label-wrapper` block (header, tooltip, `clear`). It returns an empty string without a label. A tooltip is the label's explanation or description text; it renders only in wrapped mode and only with a label, as in the TypeScript `UI_WrappedFieldLabel`.

The `label` and `tooltip` constructor params are now processed (they were ignored before; see `EF-004`).

## Cascade Rules For Field Types

| Field | Wrapper token | Behavior |
|---|---|---|
| `InputText` | `text` | Inherits the pipeline. |
| `InputEmailer` | `email` | Inherits the pipeline. |
| `InputPassword` | `pw` | The wrapper token differs from the enum value (`password`), as in TypeScript. `getElementFieldWrapperType()` owns the mapping. |
| `InputHidden` | none by default; `hidden` in a fieldset | Renders the bare input from `compileAsHtmlString()`, `string()` and `build()`. `compileAsHtmlStringWithFieldset()` and `buildWithFieldset()` render the wrapped structure (`UI_HiddenInputWrappedField`). Form hidden post variables stay bare. |
| `SelectOption` | `select` | Overrides only the control hook (`select` + options). No enum value exists, so the token comes from the tag. |
| `InputRadio` | `radio-group` (collection) | A group renders `div.field-wrapper.radio-group` with one `label[for] > div.field-inner-wrapper > input#id` plus a label block per radio, as `UI_RadioInputGroupField`. Each radio gets an id (its own, else `{groupId or name}_{index}`) so `for` and `id` pair up while the input stays nested. A single radio uses the base pipeline (`radio`) and gets `for` when it has an id. Raw radios render `div.radio-wrapper > label[for] > text + input#id`. |
| `FormButton` | `submit` / `button` | Always inside its fieldset. `submit` renders no `<label>` (as `UI_InputSubmitWrappedField`); `button` renders the label tag. |
| `SelectOptions` | none | The `<option>` stays a raw element. It is not a field part. |

New field types follow one rule: set the type, override `getElementFieldControl()` and `buildElementFieldControl()` only if the control is not a single element, and add wrapper, raw, and fieldset assertions to the Field sandbox.

## Known Gaps (tracked in `EF-066` and `EF-060`)

| Gap | Detail |
|---|---|
| Wrapper style class | TypeScript accepts `styleClass` on `field-wrapper`; PHP user classes apply to the control only. |
| Trailing spaces | TypeScript class templates emit `class="field-wrapper text "`; PHP trims. Golden fixtures must normalize whitespace (`EF-062`). |
| Fieldset class | TypeScript uses `default-fieldset` and wraps in `div.wrapper.part.presentation.fieldset`; PHP renders `generic-fieldset`. |
| Radio group label | TypeScript has no group label; PHP renders the group label block above the radios when set. Downstream projects may add extra wrapping. |
| Missing types | `tel`, `number`, `url`, `image`, `range`, `reset`, `search`, `checkbox`, `color`, `date`, `file`, `time`, `textarea` have no PHP field (`EF-020`, `EF-023`). |
| `id` and `data-field` | PHP `data-field` falls back from `name` to the factory name and id; `id` hyphenation is not mapped. |
