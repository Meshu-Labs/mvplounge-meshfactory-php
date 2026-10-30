# MvpLounge MeshFactory

This file is a routing guide for work inside `src/Labs/MeshFactory` using the `MvpLounge\MeshFactory` namespace. Keep it concise; the detailed rules live in the domain-owned docs.

## Documentation Architecture

- Root README is the primary summary for platform understanding.
- docs/.instructions.md is the docs entrypoint and namespace summary.
- docs/architecture/ is the detailed encyclopedia.

For questions, proposals, and examples, run the Architecture Clarification workflow and save reports to docs/behavior/.

If you are looking for the top-level package notes, check the repository README. This file is the local guide for work inside `MvpLounge/MeshFactory`.

## Core Direction

- The enum layer defines the available DOM elements and attributes.
- Each enum-backed element maps to a DOM element and, by design, a TypeScript element object.
- `FactoryAbstract` (in `MvpLounge\MeshFactory\Abstract`) is the shared base for DOM-style HTML element behavior.
- `FactoryElementAbstract` (in `MvpLounge\MeshFactory\Abstract`) is the shared base for element-specific behavior.
- Attribute handling is the only part that should stay dynamic.

## Factory Base Class Naming

All abstract factory base classes follow the naming convention `FactoryElement{DomDomain}Abstract` and are located in the `MvpLounge\MeshFactory\Abstract` namespace:

- `FactoryAbstract` - Root abstract providing shared DOM-level behavior
- `FactoryElementAbstract` - Element-level abstract providing element-specific behavior
- `FactoryElementFieldAbstract` - Field element families
- `FactoryElementFieldInputAbstract` - Specific input field behavior
- `FactoryElementFieldsetAbstract` - Fieldset container behavior
- `FactoryElementFormAbstract` - Form container behavior
- `FactoryElementHtml5Abstract` - HTML5 semantic element families
- `FactoryElementTableAbstract` - Table and table-related element families
- `FactoryElementLinkAbstract` - Link/anchor element behavior
- `FactoryElementCopyAbstract` - Copy/text element families

## What To Preserve

- Keep class structure deductive: enum, element, base class, then concrete element.
- Put shared behavior in the nearest base class that already owns it.
- Use explicit `getFactoryAttributePropertyCollection()` methods when a class has its own allowed attributes.
- Keep helper methods small and direct. Prefer inheritance over copying the same ternary logic in many leaf classes.
- Keep arrays flat unless nesting is required by the data shape.

## How Attribute Rules Are Deduced

- Start with the element enum. If a class extends one of those enum-backed elements, it is part of the HTML/DOM shape for that element.
- Check `AllowedFactoryElementAttributes` on the class. That is the main source for which attributes the class is allowed to expose.
- Treat `addElementOpen()` as the runtime contract for attribute collections. It passes `getFactoryAttributePropertyCollection()` straight into `getElementFactoryOpen($this->FactoryElement->value, ...)`, so that collection must describe the opening tag for the current element type.
- That means the requirements are element-specific:
	- `input` classes should return only opening-tag input attributes such as `type`, `placeholder`, `value`, `checked`, and similar allowed input attributes.
	- `select` classes should return only opening-tag select attributes, not option payloads or composed field metadata.
	- `option` classes should return only option-tag attributes such as `value` and `selected`.
	- Container or composed field data such as labels, fieldsets, grouped radio payloads, option collections, and similar model/view state belongs in `getFactoryModel()` or other concrete model methods, not in `getFactoryAttributePropertyCollection()`.
- Walk the inheritance chain before adding new logic. If the parent already exposes the right behavior, reuse it.
- Use `getFactoryAttributePropertyCollection()` to publish the final property set for rendering.
- Use helper methods for per-attribute checks when the class has special behavior or needs to gate values.
- Use the class process methods and render methods as a cross-check. If a method like `__process_*` or `getElementFactoryOpen()` already consumes an attribute, the collection method should expose it too.
- For table, form, field, html5, and link classes, the allowed attributes usually come from the family-specific enum plus any shared DOM attributes.
- For copy-style classes like `FactoryElementCopyAbstract`, read the element list directly. Text elements usually inherit shared DOM attributes only, while `img` should trigger image-specific attribute support.
- If a needed attribute enum does not exist yet, add it in the most logical enum file for that family before wiring the class.
- Treat the attribute layer as the only dynamic layer. The class structure itself should stay deductive and stable.

## Attribute Control Check

- Verify the class has `getAllowedFactoryElementAttributes()` and `getFactoryAttributePropertyCollection()` when it owns special behavior.
- Treat `FactoryDomAttributes` as implicitly allowed shared DOM state. Use `AllowedFactoryElementAttributes` as the explicit source for family-specific and leaf-specific attribute gating.
- Verify `getFactoryAttributePropertyCollection()` is the method used by `addElementOpen()` and not a parallel one-off properties array.
- Verify every value returned by `getFactoryAttributePropertyCollection()` is intended for the opening tag generated by `addElementOpen()`. If a value is not consumed as an opening-tag property for that element type, move it out of the attribute collection and into `getFactoryModel()` or another concrete model method.
- Remove legacy `getFactoryProperties()` methods once the class exposes `getFactoryAttributePropertyCollection()`. Do not keep both paths alive.
- Verify `getFactoryAttributePropertyCollection()` starts from `getDefaultFactoryAttributePropertyCollection()` and includes the shared base keys: `configuration`, `user`, `system`, and `data`.
- Never use `parent::getFactoryAttributePropertyCollection()` in child classes. Use `getDefaultFactoryAttributePropertyCollection()` when you need the base collection.
- Inject normalized allowed values into attribute getters from `$_allowed = $this->getAllowedFactoryElementAttributes();` instead of passing the raw class property inline.
- Keep the getter format explicit: validate against the family enum value and accept the injected `$allowed` array.
- In `getFactoryElement*` helpers, compare `$allowed` against enum `->value` members, not raw string literals, when an enum exists for that attribute.
- Keep the array syntax in these collection methods clean: no trailing comma on the last item.
- Example:
	```php
	$_allowed = $this->getAllowedFactoryElementAttributes();

	return array_merge(
	    $this->getDefaultFactoryAttributePropertyCollection(),
	    [
	        'for' => $this->getFactoryElementHtmlFor($_allowed)
	    ]
	);
	```
- Getter example:
	```php
	public function getFactoryElementFieldType(array $allowed): ?string
	{
	    return in_array(FactoryElementAttribute::TYPE->value, $allowed, TRUE) ? $this->getElementFieldType() : NULL;
	}
	```
- Base classes should usually return minimal collections because they define general behavior. Concrete classes may override to become more specific, but only for opening-tag requirements of their actual element type.
- Verify the attribute enum list matches the allowed element list.
- If a needed attribute enum does not exist yet, create it in the most logical enum file for that family before wiring the class.
- Keep the check deductive: start from the allowed element list, then map only the attributes that the element actually supports.
- If an attribute declaration lives on a leaf class and not on the family base, the full attribute chain should live on that leaf class too.
- That includes the storage property, the `__process_*` handler, the `add*` mutator, the `getFactoryElement*` helper, and the leaf `getFactoryAttributePropertyCollection()` override.
- Do not keep attribute-specific collection logic on a family base when the corresponding `AllowedFactoryElementAttributes` declaration only exists on a concrete child.
- For field classes, use the family rules already implied by the class shape:
	- For input fields, use `protected ?FactoryElementFieldType $FactoryElementFieldType` as the driver for `protected array $AllowedFactoryElementAttributes`.
	- Remove attributes that the field type does not need.
	- Add attributes that the field type requires.
	- If the needed attribute does not exist yet, create it in the most logical field enum location before using it.
	- Prefer `FactoryElementAttribute` when the attribute is a common HTML field/input attribute.
	- Prefer a family-specific enum only when the attribute is not a good fit for the shared field attribute set.
	- `FactoryElementFieldAbstract` owns shared field attributes like `access`, `value`, and `selected`.
	- `FactoryElementFieldInputAbstract` owns input-specific attributes like `type`, `placeholder`, and `checked`.
	- `TextInput`, `EmailerInput`, and `PasswordInput` should expose the input shape their type implies, not a broader set.
	- `HiddenInput` should stay minimal and only expose hidden-input behavior.
	- `RadioInput` should expose `checked` and the radio collection behavior.
	- `SelectOption` and `SelectOptions` should stay centered on `value` and `selected`.
	- `FormButton` should stay centered on button-type input behavior and fieldset composition.
	- `FactoryElementFieldsetAbstract` should stay focused on fieldset-level behavior only.
- For Html5 classes, keep the base generic. A class like `Label` that alone declares `FactoryElementAttribute::FOR` should also own the `for` property flow and its `getFactoryAttributePropertyCollection()` override.
- For classes that include `img`, verify the image-only attributes are modeled explicitly instead of being left implicit.
- If a class only supports shared DOM attributes, keep the collection method thin and avoid inventing extra enums.

## What This Library Is For

- This library is the HTML factory layer for larger UI work.
- It is meant to connect cleanly to `APP-MESH-UI` and TypeScript-based component construction.
- It should also stay useful for templating integration in ExpressionEngine, WordPress, osTicket, and possibly Drupal.

## Writing Style

- Keep the implementation practical.
- Favor clear logic over clever logic.
- Use the library to show real PHP features, common patterns, and common mistakes.
- Avoid overengineering. If a rule can live in one base class, keep it there.
- When generating arrays, do not leave trailing commas on the last array item.

## Current Focus

- The dynamic part of the library is attribute management.
- The rest of the shape should stay stable and predictable.

## Supported Elements

The supported DOM/HTML elements currently come from `FactoryElement`:

- Core text and media: `p`, `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `hl`, `img`
- Field and form: `fieldset`, `input`, `select`, `option`, `textarea`, `form`
- Link and layout: `a`, `div`, `span`, `label`, `aside`, `content`, `header`, `figure`, `main`, `section`, `article`, `footer`, `nav`
- Table: `th`, `td`, `tr`, `table`, `thead`, `tfoot`, `tbody`

## Supported Attribute Enums

Use these enums as the source of truth for attribute support:

- Elements: `FactoryElement`
- Attributes (shared + element-specific): `FactoryElementAttribute`
- Field input types: `FactoryElementFieldType`
- Primitive value types: `FactoryElementPrimativeType`

## Family Notes

- `FactoryAbstract` owns the shared DOM attributes and base collection shape.
- `FactoryElementAbstract` owns element-level behavior, allowed elements, and element-specific collection rules.
- `FactoryElementFieldAbstract` and its descendants handle form input behavior and value typing.
- `FactoryElementHtml5Abstract` and its descendants handle the smaller HTML5-only attribute set.
- `FactoryElementLinkAbstract` handles anchor/link-specific attribute behavior.
- `FactoryElementTableAbstract` handles table, row, cell, head, and body behavior.
- `FactoryElementFormAbstract` handles form-wide attributes and form child composition.

## Quality Control: Naming Standards Enforcement

This section defines mandatory quality checks to prevent partial migrations and naming inconsistencies.

### Critical Rules

**Rule 1: Abstract Base Class Naming Pattern**
- All abstract base factory classes MUST follow the pattern `FactoryElement{DomDomain}Abstract` or `FactoryAbstract` for the root.
- Violation: No class may use the old `*FactoryBase` pattern (e.g., `TableFactoryBase`, `FormFactoryBase`, `FieldFactoryBase`).
- Action on violation: Delete the old-named file immediately and update all references to use the new Abstract namespace version.

**Rule 2: Abstract Base Class Location**
- All abstract base factory classes MUST reside in the `MvpLounge\MeshFactory\Abstract` namespace.
- Violation: Abstract base classes may NOT reside at the root of `MvpLounge\MeshFactory` or scattered across Element/ subdirectories with old names.
- Example correct paths:
	- `src/Labs/MeshFactory/Abstract/FactoryAbstract.php`
	- `src/Labs/MeshFactory/Abstract/FactoryElementAbstract.php`
	- (Domain-specific abstracts live in `Element/` subdirectories with correct naming)

**Rule 3: Concrete Class Inheritance**
- All concrete factory classes MUST extend a new-style abstract class (using the `FactoryElement*Abstract` or `FactoryAbstract` naming pattern)
- Violation: No concrete class may extend old-style `*FactoryBase` or root-level orphaned classes.
- All concrete classes MUST import their parent abstract using the new namespace path:
	```php
	use MvpLounge\MeshFactory\Abstract\FactoryElementAbstract;
	use MvpLounge\MeshFactory\Element\Table\FactoryElementTableAbstract;
	```

**Rule 4: Return Type Hints Consistency**
- All method return type hints MUST use the actual class name, not an old or mismatched class name.
- Violation examples that must be fixed:
	- `public function addColspan($colspan): TableFactoryBase` should be `public function addColspan($colspan): FactoryElementTableAbstract`
	- `public function addAlt($alt): CopyFactoryBase` should be `public function addAlt($alt): FactoryElementCopyAbstract`
- Process: Use IDE rename refactoring to update return types when class names change.

**Rule 5: instanceof Checks**
- All `instanceof` checks MUST use the current class name (not old names).
- Violation example: `elseif ($_fl instanceof FactoryElementBase)` should be `elseif ($_fl instanceof FactoryElementAbstract)`
- Process: Update instanceof checks in the same commit as the class rename.

**Rule 6: Direct Instantiation ($new)**
- All `new ClassName()` operations MUST use the current class name.
- Violation example: `new FieldsetFactoryBase($params)` should be `new FactoryElementFieldsetAbstract($params)`
- Process: Direct instantiations must be updated when parent class names change.

**Rule 7: No Duplicate File Names**
- The codebase may NOT have both an old-named file and a new-named file in the same directory.
- Violation example: Both `TableFactoryBase.php` and `FactoryElementTableAbstract.php` should NOT coexist.
- Action on violation: Delete the old-named file and verify all references are moved to the new file.
- Migration checklist before deleting:
	1. Check all `require_once` statements - none should reference the old filename.
	2. Check all `use` statements - none should reference the old class name.
	3. Check all return type hints - none should reference the old class name.
	4. Check all `instanceof` checks - none should reference the old class name.
	5. Check all `new ClassName()` instantiations - none should reference the old class name.

### Audit Checklist

Run this check annually or before major releases to catch drift:

1. **Search for old naming patterns:**
	```powershell
	grep -r "FactoryBase" src/Labs/MeshFactory --include="*.php"
	```
	Expected result: Zero matches. Any matches indicate incomplete migrations or accidental regressions.

2. **Verify abstract class locations:**
	```powershell
	ls src/Labs/MeshFactory/*.php
	```
	Expected result: No `FactoryBase.php`, `FactoryElementBase.php`, or `*FactoryBase.php` files at root.

3. **Verify namespace consistency:**
	All files in `Element/` subdirectories with abstract classes should show:
	- Class name: `FactoryElement*Abstract`
	- Namespace: `MvpLounge\MeshFactory\Element\*`

4. **Sample return type verification:**
	Pick a few files and manually spot-check:
	- FactoryElementTableAbstract.php: Methods should return `FactoryElementTableAbstract` (not `TableFactoryBase`)
	- FactoryElementFormAbstract.php: Methods should return `FactoryElementFormAbstract` (not `FormFactoryBase`)
	- FactoryElementCopyAbstract.php: Methods should return `FactoryElementCopyAbstract` (not `CopyFactoryBase`)

5. **Check for orphaned root files:**
	Files at `src/Labs/MeshFactory/` root should NOT include:
	- `FactoryBase.php`
	- `FactoryElementBase.php`
	- Any file ending in `FactoryBase.php`

### Common Mistakes to Avoid

- **Mistake 1: Partial File Renaming**
	Creating a new file with the correct name but leaving the old file in place causes confusion and duplicate definitions.
	Fix: Delete the old file after verifying migration.

- **Mistake 2: Stale require_once Statements**
	Old require_once paths like `require_once __DIR__ . '/FieldFactoryBase.php';` will fail if you delete the old file.
	Fix: Remove require_once statements and rely on namespace imports instead.

- **Mistake 3: Mixed Return Types**
	```php
	// WRONG - mixing old and new types in same class family:
	public function addField(): FactoryElementFieldAbstract { ... }
	public function addFieldset(): FieldsetFactoryBase { ... }  // Should be FactoryElementFieldsetAbstract
	```
	Fix: Ensure all return types use consistent naming.

- **Mistake 4: Forgetting instanceof and new() Updates**
	The IDE rename refactoring catches `class Foo extends OldName` but may miss:
	- `instanceof OldName` checks
	- `new OldName()` instantiations
	- Return type hints (which don't trigger IDE rename)
	
	Fix: After renaming, search the class name explicitly and update all occurrences.

- **Mistake 5: Importing from Wrong Namespace**
	```php
	// WRONG:
	use MvpLounge\MeshFactory\Element\FactoryElementBase;
	
	// CORRECT:
	use MvpLounge\MeshFactory\Abstract\FactoryElementAbstract;
	```
	Fix: Update use statements to point to Abstract namespace for base classes.

### When Adding New Base Classes

Before creating a new abstract base class:

1. Name it following the pattern: `FactoryElement{DomainName}Abstract`
2. Place it in the appropriate location:
	- Root abstracts: `src/Labs/MeshFactory/Abstract/FactoryElement{Name}Abstract.php`
	- Family-specific abstracts: `src/Labs/MeshFactory/Element/{Family}/FactoryElement{Name}Abstract.php`
3. Extend the correct parent: `FactoryAbstract` (for root) or domain-specific parent
4. Document it in the "Factory Base Class Naming" section above
5. Do NOT create legacy-named backups or alternate file paths
6. Ensure return type hints match the new class name from day one
