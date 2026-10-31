# AX ElementFactory API Reference

Common methods of the ElementFactory, grouped by the layer that owns them. Use it to find where a method comes from before adding or overriding behavior. See the [pattern guide](AX-element-factory-pattern.md) for how the pieces fit together.

Conventions used below: **chain** means the method returns `static`; types are from the code.

## Extension Points (protected state a subclass sets)

| Property | Type | Purpose |
|---|---|---|
| `$AllowedFactoryElements` | `FactoryElement[]` | Tags this class may render. `getElementFactory()` rejects any other. |
| `$FactoryElement` | `?FactoryElement` | The tag this class renders. |
| `$AllowedFactoryElementAttributes` | `FactoryElementAttribute[]` | Element-specific attributes. Global attributes are implicit. |
| `$FactoryElementSystemClass` | `?string` | Default class token appended to `class` (for example `generic-a`, `field_ui`). |
| `$FactoryElementUserClass` | `?array` | Default user class tokens (for example `['post-form']`). |

## FactoryAbstract (root)

Shared DOM-level state and output aliases.

| Method | Returns | Notes |
|---|---|---|
| `__construct($params = [])` | | Calls `__process_params()`. |
| `configureFactory($params = [])` | chain | Re-runs param dispatch. Does not process `content` (`EF-004`). |
| `addId`, `addClass`, `addTitle`, `addStyle`, `addLang`, `addDir`, `addHidden`, `addTabindex`, `addDraggable`, `addContenteditable`, `addSpellcheck`, `addTranslate`, `addRole`, `addAriaLabel`, `addAriaLabelledby`, `addAriaDescribedby` | chain | One per global attribute. |
| `getFactoryClasses()` | `string` | Merges `class` param, user classes, and system class; removes duplicates. |
| `getDefaultFactoryAttributePropertyCollection()` | `array` | Global attributes plus `configuration`, `user`, `system`, `data`, `ext`. Every override must start from this. |
| `getFactoryAttributePropertyCollection()` | `array` | Overridden by every family. Opening-tag values only. |
| `getFactoryModel()` | `array` | Model payload for composites. |
| `compileAsArray()` / `compile()` | `?array` | Alias of `getFactoryModel()`. |
| `compileAsHtmlString()` / `string()` | `?string` | Open + content + close when the element has them. |
| `getFactoryId()`, `getFactoryName()`, `getFactoryConfiguration()`, `getFactoryUserClass()`, `getFactorySystemClass()`, `getFactoryDataParams()`, `getFactoryExtendedProperties()`, `getFactoryLang()`, `getLang($namespace)`, `getElementConfiguration()` | various | Accessors. |

## FactoryElementAbstract (element behavior)

| Method | Returns | Notes |
|---|---|---|
| `addContent($content, $overwrite = FALSE)` | chain | Appends with a space unless `$overwrite`. Content is raw (`EF-003`). |
| `addElement($element)` | chain | Accepts an enum or string; rebinds the tag. |
| `addName($name)` | chain | |
| `addClass($class)` | chain | Accepts a string (split on spaces) or an array. |
| `hasClass($class)` | `?bool` | Returns `NULL` when absent (`EF-044`). |
| `addData(array $data)` | chain | Keys lowercased; renders `data-{key}="value"`. |
| `getElementOpen()` / `getElementContent()` / `getElementClose()` | `?string` | Compose the three parts. |
| `addElementOpen()` / `addElementClose()` | `void` | Build the cached open and close strings. |
| `getElementFactoryOpen($element, $params)` | `string` | Formats a tag from an attribute collection. |
| `getElementFactoryClose($element)` | `string` | `</tag>`; empty when the tag is not allowed. |
| `getAllowedFactoryElementAttributes()` | `string[]` | Lowercase enum values; the gate used by every getter. |
| `build()`, `buildElementOpen()`, `buildElementContent()`, `buildElementClose()` | `void` | Echo variants. |

Rendering details to rely on: attribute `target` accepts only the four `FactoryElementWindowTarget` values; `selected` and `checked` render as bare names only for boolean `true`; `access` renders `enabled`/`disabled` (`EF-008`); `data` arrays render as `data-*`.

## FactoryElementHtmlAbstract (plain elements)

Returns `getDefaultFactoryAttributePropertyCollection()` unchanged. 99 classes extend it: all of the text, sectioning, inline, obsolete, root, web-component, interactive, demarcating-edit, and SVG/MathML elements. Nothing to override unless you are adding attributes.

## Family abstracts

### FactoryElementLinkAbstract

`addHref`, `addRel`, `addTitle`, `addTarget`, `addHrefLang`, `addMedia`, `addPing`, `addReferrerPolicy`, `addType` / `addLinkType`. Subclass: `Anchor`.

### FactoryElementImageAndMultimediaAbstract

`addSrc`, `addAlt`, `addLoading`, `addDecoding`, `addFetchPriority`, `addPreload`, `addPoster`, `addAutoplay`, `addControls`, `addLoop`, `addMuted`, `addCrossorigin`. Subclasses: `Img`, `Image`, `Audio`, `Video`, `Area`, `Map`, `Track` (`EF-033`).

### FactoryElementEmbeddedContentAbstract

`addSrc`, `addType` / `addEmbeddedType`, `addName` / `addEmbeddedName`, `addLoading`, `addDecoding`, `addFetchPriority`. Subclasses: `Iframe`, `Embed`, `ObjectElement`, `Param`, `Picture`, `Source`, `Fencedframe`.

### FactoryElementMetaDataAbstract

`addHref`, `addRel`, `addHreflang`, `addMedia`, `addReferrerpolicy`, `addType` / `addMetaType`, `addName` / `addMetaName`, `addAs`, `addIntegrity`, `addCrossorigin`. Subclasses: `Link`, `Meta`, `Base`, `Style`, `Title`.

### FactoryElementScriptingAbstract

`addSrc`, `addType` / `addScriptType`, `addIntegrity`, `addCrossorigin`, `addReferrerpolicy`. Subclasses: `Script`, `Canvas`, `Noscript`.

### FactoryElementTableAbstract

`addColspan`, `addRowspan`, `addScope`, `addHeaders`, `addAbbr`, `addCellspacing`, `addCellpadding`, `addBorder`. Subclasses: `TableBody`, `TableCell`, `TableHead`, `TableRow`, `TableRowBody`, `TableFooter`, and `TableHeader` via `TableCell`.

Table composites:

| Class | Renders | Methods |
|---|---|---|
| `TableBody` | `<table>` | `addHeader($content, $id, $user, $data, $extended, $system)`, `addRow($params)`, `getHeader()`, `getRowBody()`, `getFooter()` |
| `DataTableBody` | `<table>` with head, body, foot | as `TableBody` |
| `TableHead` | `<thead>` | `addHeader(...)` |
| `TableRowBody` | `<tbody>` | `addRow($params)` returns the `TableRow` |
| `TableRow` | `<tr>` | `addCell($content, $id, $user, $data, $system)`, `addHeader(...)` |
| `TableCell` / `TableHeader` | `<td>` / `<th>` | attribute `add*()` above |

### FactoryElementFormAbstract

| Method | Notes |
|---|---|
| `addAction`, `addMethod` (`post`, `get`), `addEnc` / `addEnctype`, `addNoValidate`, `addTarget`, `addAutoComplete` (`on`/`off`, default `off`), `addActivity` | Form attributes. |
| `addHiddenPostField(array $params)` | Adds a `HiddenInput`. |
| `addFormSectionFields($section, $namespace, $field)` | Registers a field under a section. |
| `addFormButton($value, $type, ...)`, `addFormSubmitButton(...)`, `addFormResetButton(...)` | Buttons (`EF-007` for reset). |
| `getFormSubmitButton()`, `getFormResetButton()`, `getHiddenPostFields()`, `getFormSectionFields($section)`, `getFormButtons()`, `getFormFields()` | Accessors. |
| `prepare()` | Arrays of HTML strings: `open`, `hidden`, `fields`, `buttons`, `close`. |
| `compileAsArray()`, `compileFormHiddenVars($string)`, `compileFormFields($string)`, `compileFormSubmitButton()`, `compileFormSection(...)` | Model variants. |
| `compileAsJson()` | `json_encode(prepare())` with unescaped slashes and Unicode. |

Subclasses: `PostForm` (default class `post-form`), `AjaxForm`.

### FactoryElementFormElementsAbstract

Only `addFor`. Subclasses: `Label`, `Button`, `Datalist`, `Legend`, `Meter`, `Optgroup`, `Output`, `Progress`. Most are bare stubs (`EF-025`, `EF-024`).

### FactoryElementFieldAbstract and FactoryElementFieldInputAbstract

| Method | Notes |
|---|---|
| `addType($type)` | Enum or string; resolved with `FactoryElementFieldType::tryFrom`. Unknown values are dropped (`EF-007`). |
| `addValueType($type)` / `addValue($value)` | Value is coerced by `FactoryElementPrimativeType` (`int`, `bool`, `string`, `float`). |
| `addAccess(bool)` | Renders `enabled` or `disabled` (`EF-008`). |
| `addLabel($label)`, `addFieldset(array)`, `addLength($n)`, `addAct($act)` | Label and fieldset need these calls; the matching params are ignored today (`EF-004`). |
| `getElementFieldLabelOpen()` / `getElementFieldLabelClose()` | `<label>text` and `</label>`. |
| `getElementFieldset()` | Lazily creates a `FactoryElementFieldsetAbstract`. |
| `compileAsHtmlString()` | Label open + input + label close. |
| `compileAsHtmlStringWithFieldset()` | Wraps in the fieldset (`EF-009`). |
| `buildWithFieldset()` | Echo variant. |
| `getFactoryModel()` | `name`, `field`, `fieldset`. |

Field leaf classes:

| Class | Type | Extra methods |
|---|---|---|
| `TextInput` | `text` | `addPlaceholder`, `getPlaceholderText` |
| `EmailerInput` | `email` | inherits `TextInput` |
| `PasswordInput` | `password` | |
| `HiddenInput` | `hidden` | |
| `RadioInput` | `radio` | `addChecked`, `addCheckedElements(array)`, `getElementRadios()`, `getElementFieldChecked()` |
| `FormButton` | `button` / `submit` | `asButton()`, `asSubmit()` |
| `SelectOption` | select | `addOptions(array)`, `getElementFieldOptions($string)`, `hasOptions()` |
| `SelectOptions` | option | `selected()`, `not_selected()`, `addSelected($bool)` |

## Enums

| Enum | Cases | Role |
|---|---|---|
| `FactoryElement` | 140 | Tags. |
| `FactoryElementAttribute` | 75 | Attributes (global and element-specific). |
| `FactoryElementFieldType` | 7 | `text`, `email`, `password`, `hidden`, `radio`, `button`, `submit` (`EF-023`). |
| `FactoryElementPrimativeType` | 4 | `int`, `bool`, `string`, `float`. |
| `FactoryElementWindowTarget` | 4 | `_self`, `_blank`, `_parent`, `_top`. |

## Where To Look First

| Task | Start in |
|---|---|
| New plain element | `Element/{Domain}/` plus `FactoryElement` |
| New attribute on one family | that family's abstract plus `FactoryElementAttribute` |
| Output format change | `FactoryAbstract` and `FactoryElementAbstract::getElementFactory*` |
| Escaping or boolean rendering | `FactoryElementAbstract::getElementFactoryScalarProperty()` (`EF-002`, `EF-003`) |
| Param handling | `FactoryAbstract::__process_params()` (`EF-004`) |
