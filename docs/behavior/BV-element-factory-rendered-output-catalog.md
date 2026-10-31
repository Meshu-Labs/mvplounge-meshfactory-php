# BV ElementFactory Rendered Output Catalog

This document records what the sandbox suite exercises and what the elements actually render, inferred by reading the tests and running the classes. Use it to decide what a "pass" currently proves and to write golden assertions ([EF-051](BV-element-factory-implementation-backlog.md)).

## Suite At A Glance

| Item | Value |
|---|---|
| Runner | `php src/Sandbox/MeshFactory/run-all.php` (or `composer test`) |
| Scripts | 333 (`*-sandbox.php`) = 111 per flavor |
| Per-class scripts | 108 classes x 3 flavors = 324 |
| Domain suites | Field, Form, Table x 3 flavors = 9 |
| Pass marker | one `PASS assertions` line per script, then `All sandbox scripts executed.` |
| Runner steps | `php -l` lint pass over every script, then each script in a child process; first non-zero exit stops the run |
| Shared helpers | `src/Sandbox/MeshFactory/_shared/factory-element-sandbox-shared.php` |
| Coverage gap | 9 classes have no script and 12 only Generic domain-suite coverage (`EF-050`) |

## The Three Flavors

| Flavor | Folder | How the element is built | What it proves |
|---|---|---|---|
| Generic | `{Domain}/Generic/` | `new Class()` plus `addClass()` and `addContent()` | The default state renders. |
| Factory | `{Domain}/Factory/` | `new Class()` then the fluent `addId()->addClass()->addTitle()->addStyle()->addLang()->addContent()` chain | The mutators chain and render. |
| Params | `{Domain}/Params/` | `new Class()`, `mfBuildScopedParams()`, then `configureFactory($params)` | Every allowed attribute accepts a sample value. |

Each script starts with `require_once bootstrap.php`, which locates `vendor/autoload.php` by walking up to 12 parent folders, so the same scripts run in the repository and inside a consumer's `vendor/` tree.

## What The Helpers Assert

`mfAssertRenderableOutputs($factory, $className)` collects five outputs and asserts only:

1. `compileAsArray()` returns an array.
2. `compileAsArray()` returns an array.
3. Some string inside the array outputs, or the JSON, HTML, or `string()` output, contains `<`.

It prints all five outputs for human review. It does not compare any of them to an expected value. Consequences:

- A wrong attribute value, a missing attribute, or an extra attribute passes.
- `compileAsJson()` prints `NULL` for every non-form element and is not asserted.
- The Params flavor builds its payload from `getAllowedFactoryElementAttributes()` plus every `__process_*` method it can find, minus `configuration`, `element`, `ext`, `system`, `user`, `params`. `configureFactory()` then ignores keys that are not in the attribute map (`data`, `content`, `label`), so those samples never render and nothing notices (`EF-004`).

`mfAttributeSampleValue()` supplies deterministic samples, for example `href` becomes `https://example.test/{suffix}`, `rows` becomes `3`, boolean media attributes become `true`, and anything else becomes `{attribute}_{suffix}`. Base attributes use the suffix, for example `el_id_div_textcontent`, `el-class-div_textcontent`, `tabindex` `7`, `role` `presentation`.

## Domain Suites (explicit assertions)

The three domain suites are the only scripts that assert specific fragments, and only in the Params flavor (Field, Form) or the Factory/Params flavors (Table). Their Generic flavors cover the remaining Form and Table classes (`FieldsetLabel`, `InputButton`, `Datalist`, `Legend`, `Meter`, `Optgroup`, `Output`, `Progress`, `TableRow`, `TableHead`, `TableFooter`, `TableRowBody`) with a fluency check (`addClass()` returns the same object) and a non-empty render.

| Suite | Scenarios | Fragments asserted |
|---|---|---|
| `Field/Generic` | `Fieldset`, `FieldsetLabel`, all field classes | Exact wrapped structure against the Storybook tree (label, tooltip, inner wrapper, clears), raw output, wrapper tokens (`text`, `email`, `pw`, `select`, `submit`, `button`, `radio-group`), bare hidden fields (wrapped only with a fieldset), radio `for`/`id` pairing, radio and select cascade, and fieldset combinations (`EF-066`) |
| `Field/Params` | `InputText`, `InputEmailer`, `FormButton`, `InputHidden`, `InputPassword`, `InputRadio`, `SelectOption`, `SelectOptions` | Every global attribute fragment (`id`, `class`, `title="..."`, `style="display:block"`, `lang`, `dir`, `hidden="hidden"`, `tabindex="2"`, `draggable`, `contenteditable`, `spellcheck`, `translate`, `role`, three ARIA attributes) plus per-class fragments such as `name="text_name"`, `type="email"`, `value="2"`, `selected`, `checked`, `enabled`, and `>Two<` |
| `Form/Factory` and `Form/Params` | Login, registration, address, and AJAX profile forms | Each form's `compileAsJson()` contains the action, field names, button label, hidden field names, and `multipart/form-data` or `_blank` where set |
| `Table/Factory` and `Table/Params` | Four-column summary, merged cell, grouped header, data table | `compileAsArray()` JSON contains attribute fragments (`colspan`, `rowspan`, `scope`, `headers`, `abbr`) and cell text |

These suites assert `enabled` on fields, which `EF-008` would change. The Params flavor does not yet assert that `label` or `fieldset` params render; `Field/Generic` pins the wrapped and raw label output.

## Rendered Output By Family (default state)

Output of a freshly constructed instance with no params, from the inventory scan.

| Family | Class | Renders |
|---|---|---|
| Text | `P`, `Div`, `Blockquote`, `Ol`, `Li`, `Time`, `Details` | `<p></p>`, `<div></div>`, ... bare tag and empty content |
| Root | `Html`, `Body` | `<html></html>`, `<body></body>` |
| Link | `Anchor` | `<a class="generic-a"></a>` |
| Media | `Img` | `<img autoplay="" controls="" loop="" muted=""></img>` (`EF-001`, `EF-002`) |
| Media | `Video` | `<video autoplay="" controls="" loop="" muted=""></video>` |
| Embedded | `Iframe` | `<iframe></iframe>` |
| Scripting | `Script` | `<script></script>` |
| Metadata | `Link`, `Meta` | `<link></link>`, `<meta></meta>` (`EF-001`) |
| SVG, MathML | `Svg`, `Math` | `<svg></svg>`, `<math></math>` |
| Field | `InputText` | `<div class="field-wrapper text" data-field="">` + label + `<div class="field-inner-wrapper"><input class="field_ui" type="text">` + clears (wrapped default; raw: `<input class="field_ui" type="text">`) |
| Form element | `FieldsetLabel` | `<label></label>` |
| Form element | `InputButton` | `<button></button>` |
| Table | `TableCell` | `<td class="generic-cell"></td>` |
| Table | `TableHeader` | `<th class="generic-th"></th>` |
| Table | `TableBody` | `<table class="generic-table"></table>` (children only in `compileAsArray()`, `EF-005`) |

Rules visible across these outputs:

- Attribute order follows the collection order: `id`, `data-*`, `class`, then the global attributes, then element-specific attributes.
- `class` merges the `class` param, user classes, and the system class, separated by single spaces without duplicates (`card shadow`, `field-class-text field_ui`, `class="post field_ui"`).
- Empty and `NULL` attributes are omitted.
- `selected`, `checked`, and boolean `true` for `access` render as bare words; `access` also renders `disabled` for `false`.
- `target` is lowercased and restricted to four values.
- `data` arrays render as `data-{key}="{value}"` with lowercase keys.

## Output Samples With Params

| Input | Output |
|---|---|
| `new Div(['id'=>'hero','content'=>'Hello'])` | `<div id="hero">Hello</div>` |
| `(new Div())->addId('hero')->addClass('card shadow')->addData(['role-id'=>7])->addContent('Hello')` | `<div id="hero" data-role-id="7" class="card shadow">Hello</div>` |
| `new Anchor(['href'=>'/home','target'=>'_blank','rel'=>'noopener','content'=>'Home'])` | `<a class="generic-a" href="/home" target="_blank" rel="noopener">Home</a>` |
| `new Anchor(['href'=>'/home','target'=>'weird','content'=>'Home'])` | `<a class="generic-a" href="/home">Home</a>` |
| `new InputText(['name'=>'n','access'=>false])` | `<input class="field_ui" name="n" type="text" disabled>` |
| `new Div(['title'=>'"><script>alert(1)</script>'])` | `<div title=""><script>alert(1)</script>"></div>` (`EF-003`) |
| `new Anchor(['href'=>'javascript:alert(1)','content'=>'x'])` | `<a class="generic-a" href="javascript:alert(1)">x</a>` (`EF-003`) |

## Rendered Structures For Composites

Table model keys (`TableBody::compileAsArray()`): `open`, `thead.{open,content,close,headers.{open,content,close,cells[]}}`, `tbody.{open,content,close,rows[].{open,content,close,cells[]}}`, `tfoot.{open,content,close}`, `close`. A cell is `{open: "<td class=\"generic-cell\">", content: "<div class=\"content\">Q1</div>", close: "</td>"}`.

Form payload keys (`prepareFactoryModel()` and `compileAsJson()`): `open`, `hidden` (name to input HTML), `fields` (section to field name to input HTML), `fieldsets` (section to the `open`, `legend`, `label`, `fields`, `close` of its fieldset), `buttons` (a `<fieldset>` containing the submit input), `close`.

## How To Turn This Into Golden Tests

1. Pick the Generic or Factory script for a class.
2. Replace `mfAssertRenderableOutputs()` with an exact comparison of `string()` to the expected HTML, and of `compileAsArray()` to the expected array.
3. For Params, assert each supplied attribute appears once in the open tag.
4. Keep the expected strings in fixture files so the TypeScript side can reuse them ([AX alignment](../architecture/AX-element-factory-typescript-alignment.md)).
5. Add the same assertions for the three composites above.
