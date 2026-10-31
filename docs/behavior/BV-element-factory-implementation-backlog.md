# BV ElementFactory Implementation Backlog

This is the inventory of known gaps in the ElementFactory, written as Given-When-Then user stories. Every story cites evidence that was reproduced against the code (not assumed). Use it with the generated element list in [AX-element-factory-inventory.md](../architecture/AX-element-factory-inventory.md): the inventory answers "which element", this backlog answers "what must be true when it is done".

## How To Read This Document

- **Priority**: `P0` security or data-integrity risk, `P1` wrong HTML or blocks EELC/TypeScript parity, `P2` completeness and hygiene.
- **Status**: `Open` unless marked `Delivered`.
- **Personas**: *Designer* (an EELC designer or facade author composing elements), *Contributor* (adds or maintains factory classes), *Platform engineer* (builds, packages, and consumes the library).
- IDs are stable. Reference them in commits and issues, for example `EF-003`.

## Backlog Summary

| ID | Title | Epic | Priority | Status |
|---|---|---|---|---|
| EF-001 | Void elements render a closing tag | A. Rendering correctness | P1 | Open |
| EF-002 | Boolean attributes render as `attr=""` or `attr="1"` | A. Rendering correctness | P1 | Open |
| EF-003 | Attribute values and URLs are not escaped or validated | A. Rendering correctness | P0 | Open |
| EF-004 | Documented params are silently ignored | A. Rendering correctness | P1 | Open |
| EF-005 | Composite elements lose children in `string()` and `build()` | A. Rendering correctness | P1 | Open |
| EF-006 | Select with string keys collapses every value to `0` | A. Rendering correctness | P1 | Open |
| EF-007 | Reset button renders `type="button"` | A. Rendering correctness | P1 | Open |
| EF-008 | `access` renders the non-HTML attribute `enabled` | A. Rendering correctness | P2 | Open |
| EF-009 | Fieldset string path echoes output | A. Rendering correctness | P2 | Open |
| EF-020 | `textarea` has no class | B. Missing elements | P1 | Open |
| EF-021 | `fieldset` class lives in `Abstract/` | B. Missing elements | P2 | Open |
| EF-022 | `hgroup` and `slot` have no class | B. Missing elements | P2 | Open |
| EF-023 | Input types cover 7 of 23 TypeScript types | B. Missing elements | P1 | Open |
| EF-024 | Select lacks multiple, optgroup, and disabled options | B. Missing elements | P1 | Open |
| EF-025 | `button` drops `type`, `name`, `value`, `disabled` | B. Missing elements | P1 | Open |
| EF-030 | Global attribute vocabulary is incomplete | C. Attribute modeling | P2 | Open |
| EF-031 | `width` and `height` are not modeled | C. Attribute modeling | P1 | Open |
| EF-032 | Text-content elements have no element-specific attributes | C. Attribute modeling | P2 | Open |
| EF-033 | `img`, `area`, `track` inherit audio/video attributes | C. Attribute modeling | P1 | Open |
| EF-034 | Table cells allow obsolete table-level attributes | C. Attribute modeling | P2 | Open |
| EF-035 | Embedded, script, link, anchor attribute gaps | C. Attribute modeling | P2 | Open |
| EF-040 | Field classes live in `Form/` but use the `Field` namespace | D. Structure and hygiene | P2 | Open |
| EF-041 | Two abstract classes are dead, one has broken requires | D. Structure and hygiene | P2 | Open |
| EF-042 | Table class names do not match their tags | D. Structure and hygiene | P2 | Open |
| EF-043 | Output API contract is not uniform | D. Structure and hygiene | P1 | Open |
| EF-044 | Small defects in field and class helpers | D. Structure and hygiene | P2 | Open |
| EF-045 | README states PHP 8.1 but the package requires 8.2 | D. Structure and hygiene | P2 | Delivered |
| EF-050 | 9 classes have no sandbox and 12 have only Generic coverage | E. Test depth | P1 | Open |
| EF-051 | Sandbox assertions do not pin rendered output | E. Test depth | P1 | Open |
| EF-052 | Sandbox runner portable and enforced in CI | E. Test depth | P1 | Delivered |
| EF-053 | Sandbox template documents are missing | E. Test depth | P2 | Delivered |
| EF-060 | Field parts do not match TypeScript DOM structure | F. TypeScript alignment | P1 | Open |
| EF-061 | Table has a PHP implementation but no TypeScript `_type` | F. TypeScript alignment | P1 | Open |
| EF-062 | No shared golden fixtures between PHP and Storybook | F. TypeScript alignment | P1 | Open |
| EF-063 | Prop and enum names are not mapped | F. TypeScript alignment | P2 | Open |
| EF-064 | No PHP counterpart for `Button.Generic` | F. TypeScript alignment | P2 | Open |
| EF-065 | No PHP counterparts for `Copy.*` parts | F. TypeScript alignment | P2 | Open |
| EF-070 | Installable artifact and CI upload | G. Packaging and consumption | P1 | Delivered |
| EF-071 | First Linux CI run of the sandbox suite | G. Packaging and consumption | P1 | Open |
| EF-072 | EELC pins `dev-main` instead of a release | G. Packaging and consumption | P2 | Open |
| EF-073 | EELC facades still assemble raw HTML | G. Packaging and consumption | P1 | Open |

---

## Epic A. Rendering Correctness

### EF-001 Void elements render a closing tag (P1)

**Evidence**: `<br></br>`, `<hr></hr>`, `<img ...></img>`. Affected classes: `Img`, `Area`, `Base`, `Br`, `Col`, `Embed`, `Hr`, `Link`, `Meta`, `Param`, `Source`, `Track`, `Wbr`.

- **Given** a designer renders a void element such as `Br`, `Hr`, `Img`, or `Meta`
- **When** `compileAsHtmlString()`, `string()`, or `compileAsArray()` runs
- **Then** the output contains only the opening tag, for example `<br>`
- **And** `compileAsArray()['close']` is an empty string
- **And** the sandbox asserts the absence of `</br>`, `</hr>`, `</img>`, and the other void closers.

### EF-002 Boolean attributes render as `attr=""` or `attr="1"` (P1)

**Evidence**: `new Img(['src'=>'/a.png'])` renders `<img src="/a.png" autoplay="" controls="" loop="" muted="">`. `new Video(['controls'=>true])` renders `controls="1"`. `new Div(['hidden'=>false])` renders `hidden=""`. In HTML an attribute that is present is true, so a `false` value must never emit the attribute.

- **Given** a boolean attribute (`autoplay`, `controls`, `loop`, `muted`, `hidden`, `checked`, `selected`, `disabled`, `novalidate`, `multiple`, `required`, `readonly`, `open`)
- **When** the value is `false` or `null`
- **Then** the attribute is omitted
- **And** when the value is `true` the attribute renders as the bare name (`controls`)
- **And** a freshly constructed `Video` renders no boolean attributes.

### EF-003 Attribute values and URLs are not escaped or validated (P0)

**Evidence**: `new Div(['title'=>'"><script>alert(1)</script>'])` renders `<div title=""><script>alert(1)</script>"></div>`. `new Anchor(['href'=>'javascript:alert(1)'])` renders the `javascript:` URL unchanged. `FactoryElementAbstract::getElementFactoryScalarProperty()` formats with `sprintf('%s="%s"')` and no encoding.

- **Given** an attribute value that contains quotes, angle brackets, or ampersands
- **When** the element renders
- **Then** the value is encoded with `htmlspecialchars(..., ENT_QUOTES | ENT_HTML5)` so it cannot terminate the attribute
- **And** URL attributes (`href`, `src`, `action`, `poster`, `srcset`) reject schemes outside an allow-list (`http`, `https`, `mailto`, `tel`, relative) unless explicitly opted in
- **And** the content policy is documented: `addContent()` accepts trusted markup, and a `addText()` variant encodes
- **And** a sandbox asserts the encoded output for each case.

### EF-004 Documented params are silently ignored (P1)

**Evidence**: `new P(['data'=>['k'=>'v'], 'user'=>['b','c'], 'system'=>'sys'])` renders `<p>` with no data attribute, no user classes, no system class. `new TextInput(['label'=>'Email', 'fieldset'=>['id'=>'fs']])` renders no label and no fieldset id. `new PostForm(['name'=>'login'])` leaves `method` unchanged. Root cause: `FactoryAbstract::__process_params()` dispatches only keys present in the attribute map (global plus allowed enum attributes), so handlers such as `__process_data`, `__process_user`, `__process_system`, `__process_configuration`, `__process_ext`, `__process_label`, `__process_fieldset`, and `__process_act` are unreachable. Only `content` works because the constructor special-cases it. `SelectOption` passes `data`, `user`, and `system` to `SelectOptions` expecting them to work.

- **Given** a designer passes `data`, `user`, `system`, `configuration`, `ext`, `label`, `fieldset`, or `act` in the constructor array or `configureFactory()`, or passes `content` to `configureFactory()` (`new Anchor()->configureFactory(['content'=>'Home'])` renders an empty anchor because only the constructor handles `content`)
- **When** the factory processes params
- **Then** each key reaches its `__process_*` handler
- **And** unknown keys are still ignored safely
- **And** the Params sandbox asserts that each of those keys changes the rendered output or model
- **And** `PostForm::__process_name()` stops assigning `name` to `method`.

### EF-005 Composite elements lose children in `string()` and `build()` (P1)

**Evidence**: `TableBody::string()` returns `<table class="generic-table"></table>` while `compileAsArray()` returns thead, tbody, and tfoot. `PostForm` has the same shape: no override of `compileAsHtmlString()`, so only `prepare()` and `compileAsJson()` carry fields. `TableBody::build()` echoes `<thead class="generic-thead">` twice and never closes it, producing malformed HTML.

- **Given** a `TableBody`, `DataTableBody`, `TableHead`, `TableRowBody`, `TableRow`, or `PostForm` with children
- **When** `string()` or `compileAsHtmlString()` runs
- **Then** the full nested markup is returned
- **And** `build()` echoes the same markup as `string()` byte for byte
- **And** the `Table` and `Form` sandboxes assert `string()` equals the concatenation of the `compileAsArray()` parts.

### EF-006 Select with string keys collapses every value to `0` (P1)

**Evidence**: `SelectOption(['value'=>'b'])` with `addOptions(['a'=>'A','b'=>'B'])` renders `<select ... value="0"><option value="0">A</option><option value="0">B</option></select>`. `SelectOption` defaults `FactoryElementFieldValueType` to `INT`, so `addValue()` runs `intval('b')`. `getElementFieldOptions()` also compares the selected value to the option key with `===`. The select tag also emits `value="..."`, which is not a `select` attribute.

- **Given** a select whose option keys are strings (`'a'`, `'b'`)
- **When** it renders with a current value `'b'`
- **Then** each option keeps its own `value`
- **And** only the matching option carries `selected`
- **And** integer and string keys compare consistently (`'2'` matches `2`)
- **And** the `<select>` tag emits no `value` attribute.

### EF-007 Reset button renders `type="button"` (P1)

**Evidence**: `PostForm::getFormResetButton()->compileAsHtmlString()` returns `<input type="button" value="Reset">`. `FactoryElementFieldType` has `TEXT, EMAIL, PASSWORD, HIDDEN, RADIO, BUTTON, SUBMIT` and no `RESET`, so `addType('reset')` is dropped and the `FormButton` default applies.

- **Given** a form with a reset button
- **When** it renders
- **Then** the input has `type="reset"`
- **And** `FactoryElementFieldType` contains `RESET`
- **And** `addFormResetButton()` is covered by the Form sandbox.

### EF-008 `access` renders the non-HTML attribute `enabled` (P2)

**Evidence**: field classes render `... enabled` or `... disabled`. HTML defines only `disabled`.

- **Given** a field with `access => true`
- **When** it renders
- **Then** no `enabled` attribute is emitted
- **And** `access => false` renders `disabled`
- **And** the existing field sandbox expectations that assert `enabled` are updated.

### EF-009 Fieldset string path echoes output (P2)

**Evidence**: `FactoryElementFieldAbstract::compileAsHtmlStringWithFieldset()` calls `buildElementContent()`, which `echo`es a newline and tab and returns `null`. Callers see stray whitespace in output and no content in the returned string.

- **Given** a field rendered with `compileAsHtmlStringWithFieldset()`
- **When** the call returns
- **Then** nothing has been written to the output buffer
- **And** the returned string includes the element content.

---

## Epic B. Missing Elements

### EF-020 `textarea` has no class (P1)

**Evidence**: `FactoryElement::TEXTAREA` exists, `getElementFactoryOpen()` has a `textarea` branch, and TypeScript has `Field.Textarea`. No class is bound.

- **Given** a designer needs a multi-line field
- **When** they instantiate `MvpLounge\MeshFactory\Element\Form\Textarea`
- **Then** it supports `name`, `rows`, `cols`, `placeholder`, `wrap`, `maxlength`, `minlength`, `readonly`, `required`, `disabled`
- **And** content renders as the element body
- **And** it renders the same DOM as TypeScript `UI_TextareaWrappedField`
- **And** Generic, Factory, and Params sandboxes exist.

### EF-021 `fieldset` class lives in `Abstract/` (P2)

**Evidence**: `FactoryElementFieldsetAbstract` is concrete but sits in `Abstract/` and carries the `Abstract` suffix. Every field instantiates it directly.

- **Given** a contributor looks for the fieldset element
- **When** they browse `Element/Form/`
- **Then** a `Fieldset` class is bound to `FactoryElement::FIELDSET`
- **And** `FactoryElementFieldsetAbstract` is removed or becomes a true abstract
- **And** it supports `disabled`, `form`, `name`, and a legend.

### EF-022 `hgroup` and `slot` have no class (P2)

- **Given** the enum lists `hgroup` and `slot`
- **When** a designer looks for matching classes
- **Then** `SectioningContent\Hgroup` (or `TextContent`, per MDN grouping) and `WebComponents\Slot` exist
- **And** `Slot` supports `name`.

### EF-023 Input types cover 7 of 23 TypeScript types (P1)

**Evidence**: PHP `FactoryElementFieldType` has 7 cases. TypeScript `UI_Field_InputType_Enum` has `text, tel, email, password, number, url, hidden, submit, image, range, reset, search, button, checkbox, color, date, file, time, select, option, radio, radio-group, textarea`.

- **Given** a designer needs a checkbox, number, tel, url, search, date, time, color, file, image, range, or reset input
- **When** they instantiate the matching class
- **Then** it renders `type="..."` with the type-specific attributes (`min`, `max`, `step`, `accept`, `multiple`, `pattern`, `size`)
- **And** the enum values match the TypeScript enum names and values
- **And** `RadioInput` supports `checked` for `RadioGroup` and `Checkbox` consistently.

### EF-024 Select lacks multiple, optgroup, and disabled options (P1)

**Evidence**: TypeScript `UI_SelectField` supports `multiple` and per-option `disabled`. PHP `Optgroup` is a stub, `SelectOption` has no `multiple`, `size`, `required`, `disabled`, and `SelectOptions` has no `disabled` or `label`.

- **Given** a designer builds a grouped or multi-select control
- **When** they call `addOptions()` with groups and per-option flags
- **Then** `<optgroup label>` wraps grouped options
- **And** `multiple`, `size`, `required`, `disabled` render on the select
- **And** `disabled` and `label` render on options.

### EF-025 `button` drops `type`, `name`, `value`, `disabled` (P1)

**Evidence**: `new Button(['content'=>'Go','type'=>'submit','name'=>'b'])` renders `<button>Go</button>`. The class allows only `for`, which is not a `button` attribute.

- **Given** a designer renders a button
- **When** they pass `type`, `name`, `value`, `disabled`, `form`
- **Then** they render on the tag
- **And** `for` is removed from the allowed list.

---

## Epic C. Attribute Modeling

Counts below come from the generator: 105 spec attributes not yet modeled and 115 allowed attributes that are not defined for their element. See the per-class columns in the inventory.

### EF-030 Global attribute vocabulary is incomplete (P2)

**Evidence**: not in `FactoryElementAttribute` or the global list: `accesskey`, `autocapitalize`, `autofocus`, `enterkeyhint`, `inert`, `inputmode`, `is`, `itemid`, `itemprop`, `itemref`, `itemscope`, `itemtype`, `nonce`, `part`, `popover`, `slot`.

- **Given** a designer needs a global attribute from the HTML Standard
- **When** they pass it as a param or call its `add*()` method
- **Then** it renders on every element
- **And** `aria-*` beyond the three modeled ones are supported through a documented pattern.

### EF-031 `width` and `height` are not modeled (P1)

- **Given** a designer renders `img`, `video`, `iframe`, `canvas`, `embed`, `object`, or `source`
- **When** they pass `width` and `height`
- **Then** both render
- **And** the enum and the family abstracts allow them.

### EF-032 Text-content elements have no element-specific attributes (P2)

**Evidence**: `ol` (`reversed`, `start`, `type`), `li` (`value`), `blockquote` and `q` (`cite`), `del` and `ins` (`cite`, `datetime`), `time` (`datetime`), `data` (`value`), `details` and `dialog` (`open`), `col` and `colgroup` (`span`), `map` (`name`). They are all `Stub` tier.

- **Given** a designer renders `ol`, `li`, `blockquote`, `q`, `del`, `ins`, `time`, `data`, `details`, `dialog`, `col`, `colgroup`, or `map`
- **When** they set the element-specific attribute
- **Then** it renders
- **And** the attribute is defined once in the enum and allowed on only the elements that define it.

### EF-033 `img`, `area`, `track` inherit audio/video attributes (P1)

**Evidence**: all three extend `FactoryElementImageAndMultimediaAbstract`, which allows `preload`, `poster`, `autoplay`, `controls`, `loop`, `muted`. `Area` also allows `src`; it needs `href`, `coords`, `shape`, `alt`, `target`. `Track` needs `kind`, `label`, `srclang`, `default`.

- **Given** a designer renders `img`, `area`, `track`, `audio`, or `video`
- **When** the class resolves allowed attributes
- **Then** each element allows only the attributes the standard defines for it
- **And** the abstract splits into image, audio/video, and image-map families (or per-class allow lists).

### EF-034 Table cells allow obsolete table-level attributes (P2)

**Evidence**: `TableCell` allows `border`, `cellspacing`, `cellpadding`, `scope`, `abbr`. `scope` and `abbr` are `th` attributes; `border`, `cellspacing`, `cellpadding` are obsolete.

- **Given** a designer renders `td` or `th`
- **When** the class resolves allowed attributes
- **Then** `td` allows `colspan`, `rowspan`, `headers`
- **And** `th` additionally allows `abbr`, `scope`
- **And** presentational table attributes remain only on `table`, documented as legacy.

### EF-035 Embedded, script, link, anchor attribute gaps (P2)

**Evidence**: `iframe` (`allow`, `sandbox`, `srcdoc`, `referrerpolicy`), `script` (`async`, `defer`, `nomodule`, `blocking`, `fetchpriority`), `link` (`blocking`, `fetchpriority`, `sizes`), `a` (`download`), `object` (`data`, `form`, `usemap`), `source` (`srcset`, `sizes`, `media`).

- **Given** a designer renders those elements
- **When** they set the attributes
- **Then** each renders
- **And** the inventory shows no remaining gap for those rows.

---

## Epic D. Structure and Hygiene

### EF-040 Field classes live in `Form/` but use the `Field` namespace (P2)

**Evidence**: `TextInput`, `EmailerInput`, `PasswordInput`, `HiddenInput`, `RadioInput`, `FormButton`, `SelectOption`, `SelectOptions` are in `Element/Form/` with namespace `...\Element\Field`. They resolve only through Composer's `classmap` (see `composer.json`). `AX-implementation-contracts.md` requires namespace and folder to match.

- **Given** a consumer autoloads a field class
- **When** Composer resolves it with PSR-4 alone
- **Then** the namespace matches the folder
- **And** the `classmap` entry can be removed from `composer.json`
- **And** a deprecation alias keeps `Element\Field\*` working for EELC until `EF-072` ships a major version.

### EF-041 Two abstract classes are dead, one has broken requires (P2)

**Evidence**: `FactoryElementHtml5Abstract` has no subclasses and requires `Element/Field/FormButton.php` and `Element/Field/HiddenInput.php`, which do not exist. `FactoryElementCopyAbstract` has no subclasses, although docs name it as the base for text elements (`P`, `H1`-`H6` extend `FactoryElementHtmlAbstract`). The `Element/Links/` folder exists with no classes (`Anchor` lives in `InlineTextSemantics`), while docs and VS Code tasks still mention a Links domain.

- **Given** a contributor reads the abstract layer
- **When** they list `Abstract/`
- **Then** every file is extended by at least one class
- **And** every `require_once` target exists
- **And** docs name the real base classes.

### EF-042 Table class names do not match their tags (P2)

**Evidence**: `TableBody` renders `<table>`, `TableRowBody` renders `<tbody>`, `DataTableBody` renders `<table>` with head, body, and foot. EELC imports them under those names.

- **Given** a contributor adds table behavior
- **When** they look for the class for an element
- **Then** class names follow tag names (`Table`, `Tbody`, `Thead`, `Tfoot`, `Tr`, `Th`, `Td`) or a documented naming rule
- **And** the old names remain as deprecated aliases until `EF-072`.

### EF-043 Output API contract is not uniform (P1)

**Evidence**: `compileAsJson()` exists only on `FactoryElementFormAbstract`; `AG-app-eelc-referential-instructions.md` lists it as part of the contract for every element. EELC facades call `string()`. `compile()` and `compileAsArray()` are aliases. `build()` echoes and returns `null`.

- **Given** a consumer calls any output method on any element
- **When** the element renders
- **Then** `compileAsHtmlString()`, `string()`, `compileAsArray()`, `compile()`, and `compileAsJson()` exist on `FactoryAbstract` with consistent semantics
- **And** `compileAsJson()` returns the JSON encoding of `compileAsArray()`
- **And** `build()` is documented as legacy echo output.

### EF-044 Small defects in field and class helpers (P2)

**Evidence**:
- `FactoryElementFieldAbstract::getElementFieldLength()` returns `FactoryElementFieldLabel` and is typed `?string` instead of the length.
- `TextInput::__process_rlaceholder()` is a typo of `placeholder`.
- `FactoryElementFieldAbstract::__process_length()` calls `addlength()` (case mismatch).
- `FactoryElementAbstract::hasClass()` returns `NULL` instead of `FALSE`.
- `FactoryElementAbstract::addClass()` has an unreachable `else` branch because `explode()` always returns an array.
- `FactoryElementAbstract::__process_ext()` can never populate values because `FactoryElementExtendedAttributes` defaults to `NULL`.
- `FactoryElementFormAbstract::buildFormResetButton()` returns the result of `build()` (which is `null`) concatenated with whitespace, and `buildFormHiddenPostVars()` / `buildFormSubmitButton()` echo it, so nothing meaningful is returned.
- Code comments say "change file name to InputText..." on several field classes.

- **Given** a contributor reviews the field and class helpers
- **When** they run the audit in `TK-quality-check-playbook.md`
- **Then** each listed item is fixed or removed
- **And** `hasClass()` returns `bool`.

### EF-045 README states PHP 8.1 but the package requires 8.2 (P2, Delivered)

- **Given** a platform engineer reads the README
- **When** they compare it with `composer.json` (`"php": ">=8.2"`)
- **Then** both state PHP 8.2 or later.

---

## Epic E. Test Depth

### EF-050 9 classes have no sandbox and 12 have only Generic coverage (P1)

**Evidence** (from the inventory `Tests` column): no script of any flavor for `P`, `H1`, `H2`, `H3`, `H4`, `H5`, `H6`, `Hl`, `Img`. Covered only by the Generic flavor of the Form or Table domain suite: `Label`, `Button`, `Datalist`, `Legend`, `Meter`, `Optgroup`, `Output`, `Progress`, `TableRow`, `TableHead`, `TableFooter`, `TableRowBody`. APP-EELC imports `P`, `H1`-`H6`, `Hl`, `Img`, and the table classes directly.

- **Given** a class is imported by an EELC facade or has element-specific attributes
- **When** the sandbox suite runs
- **Then** a Generic, Factory, and Params script exists for it
- **And** the inventory `Tests` column shows uppercase `GFP` for every class.

### EF-051 Sandbox assertions do not pin rendered output (P1)

**Evidence**: `mfAssertRenderableOutputs()` only requires that `compileAsArray()` and `compile()` return arrays and that some string contains `<`. The Params flavor passes generated sample values but asserts nothing about them. A broken attribute still passes.

- **Given** a sandbox script renders an element with known inputs
- **When** it asserts
- **Then** it compares against an expected HTML string (golden) for the open tag, content, and close tag
- **And** the Params flavor asserts every supplied attribute appears exactly once
- **And** the goldens are the same fixtures consumed by `EF-062`.

### EF-052 Sandbox runner portable and enforced in CI (P1, Delivered)

- **Given** a contributor or the CI runner has any PHP 8.2+ binary
- **When** they run `composer test` or `php src/Sandbox/MeshFactory/run-all.php`
- **Then** the suite uses the running PHP (`PHP_BINARY`) instead of a hard-coded Windows path
- **And** `.github/workflows/quality.yml` runs the suite on every pull request.

### EF-053 Sandbox template documents are missing (P2, Delivered)

**Evidence**: 222 sandbox scripts cite `docs/tasks/TK-factory-sandbox-template.md` and `docs/tasks/TK-params-sandbox-template.md`, which did not exist.

- **Given** a contributor opens a sandbox script
- **When** they follow its template reference
- **Then** the document exists and points to the template sections in the quality playbook.

---

## Epic F. TypeScript Alignment

See [AX-element-factory-typescript-alignment.md](../architecture/AX-element-factory-typescript-alignment.md) for the mapping these stories rely on.

### EF-060 Field parts do not match TypeScript DOM structure (P1)

**Evidence**: TypeScript `UI_*WrappedField` renders `div.field-wrapper.{type} > label > div.field-inner-wrapper > .field_ui + div.clear`. PHP `TextInput::compileAsHtmlString()` renders `<label>text<input class="field_ui">` with no wrapper divs, and the `label` param is currently ignored (`EF-004`).

- **Given** a designer renders a text, select, or textarea field
- **When** they call the PHP composite (`FieldWrapper` or equivalent)
- **Then** it returns the same element tree and class tokens as the TypeScript part
- **And** the golden fixture (`EF-062`) passes in both languages.

### EF-061 Table has a PHP implementation but no TypeScript `_type` (P1)

**Evidence**: `src/library/Foundation/Module/Table` has only `_script` and `_style`. PHP has the most complete composite (head, body, foot, rows, cells).

- **Given** the TypeScript library needs a table atom
- **When** it adds `Module/Table/_type/Table.module.tsx`
- **Then** its DOM matches the PHP `TableBody` model (`generic-table`, `generic-thead`, `generic-tr`, `generic-th`, `generic-cell`, `generic-tbody`, `generic-footer`)
- **And** both share one golden fixture.

### EF-062 No shared golden fixtures between PHP and Storybook (P1)

- **Given** a contributor changes either implementation
- **When** CI runs
- **Then** both sides render the same input fixture (JSON) and compare to the same expected HTML
- **And** a mismatch fails the build with a diff.

### EF-063 Prop and enum names are not mapped (P2)

**Evidence**: TypeScript props live under `partFieldMeta` (`name`, `label`, `tooltip`, `fieldStyleClass`, `multiple`, `options`, `cols`, `rows`, `wrap`) and `moduleMeta` (`formId`, `formAction`, `formEnctype`, `formMethod`, `formTarget`); PHP uses flat params (`name`, `action`, `method`).

- **Given** a designer moves a component between PHP and TypeScript
- **When** they use the documented map
- **Then** each prop has one counterpart or an explicit "none"
- **And** the enums for field types match (`EF-023`).

### EF-064 No PHP counterpart for `Button.Generic` (P2)

**Evidence**: `UI_Button_HtmlPart` renders `div.html-button.{class} > div.button-wrapper > a[href,title,target] + div.clear`.

- **Given** a designer needs the styled link button
- **When** they instantiate a PHP `ButtonPart`
- **Then** it renders the identical tree.

### EF-065 No PHP counterparts for `Copy.*` parts (P2)

**Evidence**: TypeScript has `Copy.Paragraph`, `Copy.Header` (`h1`-`h6`), `Copy.Lists`, `Copy.Images`. PHP has the bare elements and EELC `Element::Date()` hand-wires `P`.

- **Given** a designer needs a styled paragraph, heading, list, or image
- **When** they use the PHP part
- **Then** class tokens (`gen-para`, ...) and structure match the TypeScript part.

---

## Epic G. Packaging and Consumption

See [TK-package-and-xamppire-consumption.md](../tasks/TK-package-and-xamppire-consumption.md).

### EF-070 Installable artifact and CI upload (P1, Delivered)

- **Given** a platform engineer needs a build to test locally
- **When** they run `composer artifact -- --version=dev-local` or the Quality workflow
- **Then** they get `mvplounge-meshfactory-<version>.zip` that contains only `composer.json` and `src/Labs/MeshFactory`
- **And** Composer installs it through an `artifact` repository (a `version` is injected because Composer requires one)
- **And** the zip content equals `composer archive` output (195 entries, verified).

### EF-071 First Linux CI run of the sandbox suite (P1)

**Evidence**: the suite and artifact were verified on Windows with PHP 8.2.12. An include-path case check found no case mismatches. A Linux run was not possible locally.

- **Given** the updated Quality workflow runs on `ubuntu-latest`
- **When** the first pull request triggers it
- **Then** `composer test` passes with 333 `PASS assertions` lines
- **And** the `mvplounge-meshfactory-artifact` artifact is attached to the run.

### EF-072 EELC pins `dev-main` instead of a release (P2)

**Evidence**: `lab_center/composer.json` requires `"mvplounge/meshfactory": "dev-main"` with `preferred-install` `dist`; `installed.json` shows a dist zipball from `Meshu-Labs/mvplounge-meshfactory-php` at a pinned commit.

- **Given** the ElementFactory stabilizes
- **When** a release is cut with the Publish workflow
- **Then** EELC requires a semantic version constraint
- **And** renamed or moved classes (`EF-040`, `EF-042`) ship in a major version with deprecation aliases.

### EF-073 EELC facades still assemble raw HTML (P1)

**Evidence**: in `lab_center/libraries/resource/ui`, `Field.php` has 22 lines and `Form.php` 13 lines that build `<select>`, `<option>`, `<textarea>`, `<fieldset>` strings by hand. `Table.php::TableOpen()` and `TableElement()` build table tags by hand while the factory has table classes.

- **Given** an EELC facade builds a select, textarea, or table
- **When** the missing factory features land (`EF-005`, `EF-020`, `EF-024`)
- **Then** the facade delegates to the factory and returns `string()`
- **And** rendered output is compared before and after, as the migration checklist in `AG-app-eelc-referential-instructions.md` requires.
