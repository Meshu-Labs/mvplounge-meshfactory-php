<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Field Sandbox (Generic) ===' . PHP_EOL;

try {
    $assert = static function (bool $condition, string $message): void {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    };

    $factories = [
        'InputText' => new \MvpLounge\MeshFactory\Element\Field\InputText(),
        'InputEmailer' => new \MvpLounge\MeshFactory\Element\Field\InputEmailer(),
        'FormButton' => new \MvpLounge\MeshFactory\Element\Field\FormButton(),
        'InputHidden' => new \MvpLounge\MeshFactory\Element\Field\InputHidden(),
        'InputPassword' => new \MvpLounge\MeshFactory\Element\Field\InputPassword(),
        'InputRadio' => new \MvpLounge\MeshFactory\Element\Field\InputRadio(),
        'SelectOption' => new \MvpLounge\MeshFactory\Element\Field\SelectOption(),
        'SelectOptions' => new \MvpLounge\MeshFactory\Element\Field\SelectOptions()
    ];

    foreach ($factories as $label => $factory) {
        $assert($factory->addClass('generic-' . strtolower($label)) === $factory, $label . ' addClass() must remain fluent.');

        echo '-- ' . $label . ' compileAsHtmlString() --' . PHP_EOL;
        $html = $factory->compileAsHtmlString();
        var_dump($html);
        $assert(is_string($html), $label . ' compileAsHtmlString() must return a string.');
    }

    $firstField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('first')->addLabel('First');
    $replacementField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('replacement');
    $secondField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('second');
    $fieldHtml = $firstField->compileAsHtmlString();
    $assert(str_contains($fieldHtml, '<label><div class="field-inner-label-wrapper"><span class="fld-label-header">First</span>'), 'The label must precede and wrap the input.');
    $assert(str_contains($fieldHtml, '</div></label><div class="clear"></div></div>'), 'The label must close after the inner wrapper and the field wrapper must close after the label.');

    $textExpected = '<div class="field-wrapper text" data-field="sample_text_field">'
        . '<label><div class="field-inner-label-wrapper"><span class="fld-label-header">Text Field</span><span class="fld-label-tooltip">The quick brown fox</span><div class="clear"></div></div>'
        . '<div class="field-inner-wrapper">%s<div class="clear"></div></div>'
        . '</label><div class="clear"></div></div>';
    $storybookText = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('sample_text_field')->addLabel('Text Field')->addTooltip('The quick brown fox');
    $assert($storybookText->compileAsHtmlString() === sprintf($textExpected, $storybookText->getElementOpen()), 'The default field output must match the Storybook wrapped field structure.');
    $assert($storybookText->string() === $storybookText->compileAsHtmlString(), 'string() must return the wrapped default.');
    ob_start();
    $storybookText->build();
    $assert(preg_replace('/\s*\n\t/', '', (string) ob_get_clean()) === sprintf($textExpected, $storybookText->getElementOpen()), 'build() must echo the wrapped default.');

    $rawText = $storybookText->compileAsHtmlStringUnwrapped();
    $assert($rawText === '<label>Text Field' . $storybookText->getElementOpen() . '</label>', 'The raw field must render a bare label around the control.');
    $assert(!str_contains($rawText, 'field-wrapper') && !str_contains($rawText, 'field-inner-wrapper') && !str_contains($rawText, 'fld-label-tooltip'), 'The raw field must not render wrapper or tooltip markup.');
    ob_start();
    $storybookText->buildUnwrapped();
    $assert(preg_replace('/\s*\n\t/', '', (string) ob_get_clean()) === $rawText, 'buildUnwrapped() must echo the raw field.');
    $assert((new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('plain')->compileAsHtmlStringUnwrapped() === (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('plain')->getElementOpen(), 'A raw field without a label must render the bare control.');

    $noLabelField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('no_label')->addTooltip('Ignored without a label');
    $assert(str_starts_with($noLabelField->compileAsHtmlString(), '<div class="field-wrapper text" data-field="no_label"><label><div class="field-inner-wrapper">'), 'A wrapped field without a label must skip the label block and its tooltip.');

    $wrapperTypes = [
        'pw' => new \MvpLounge\MeshFactory\Element\Field\InputPassword(),
        'email' => new \MvpLounge\MeshFactory\Element\Field\InputEmailer(),
        'text' => new \MvpLounge\MeshFactory\Element\Field\InputText(),
        'select' => new \MvpLounge\MeshFactory\Element\Field\SelectOption(),
        'submit' => (new \MvpLounge\MeshFactory\Element\Field\FormButton())->asSubmit(),
        'button' => (new \MvpLounge\MeshFactory\Element\Field\FormButton())->asButton()
    ];
    foreach ($wrapperTypes as $token => $typed) {
        $typedHtml = $typed->addName('typed_field')->compileAsHtmlString();
        $assert(str_contains($typedHtml, '<div class="field-wrapper ' . $token . '" data-field="typed_field">'), $token . ' must render the Storybook wrapper token.');
        $assert(str_contains($typedHtml, '<div class="field-inner-wrapper">'), $token . ' must render the inner wrapper.');
        $assert(!str_contains($typed->compileAsHtmlStringUnwrapped(), 'field-wrapper'), $token . ' raw output must not render the wrapper.');
    }
    $assert(!str_contains((new \MvpLounge\MeshFactory\Element\Field\FormButton())->asSubmit()->compileAsHtmlString(), '<label>'), 'A submit button must not render a label tag.');
    $assert(str_contains((new \MvpLounge\MeshFactory\Element\Field\FormButton())->asButton()->compileAsHtmlString(), '<label>'), 'A button must render a label tag.');

    $selectHtml = (new \MvpLounge\MeshFactory\Element\Field\SelectOption())->addName('salutation')->addLabel('Salutation')->addOptions(['Mr' => 'Mr.', 'Ms' => 'Ms.'])->compileAsHtmlString();
    $assert(str_contains($selectHtml, '<div class="field-inner-wrapper"><select') && str_contains($selectHtml, '</select><div class="clear"></div></div></label>'), 'A select must render its options inside the inner wrapper.');
    $assert(str_contains($selectHtml, '<option') && str_contains($selectHtml, '>Mr.<'), 'A select must render its options.');

    $radioGroup = (new \MvpLounge\MeshFactory\Element\Field\InputRadio())->addName('choice')->addCheckedElements([
        ['value' => 'a', 'label' => 'Option A'],
        ['value' => 'b', 'label' => 'Option B']
    ]);
    $radioHtml = $radioGroup->compileAsHtmlString();
    $assert(str_starts_with($radioHtml, '<div class="field-wrapper radio-group" data-field="choice">'), 'A radio group must render the radio-group wrapper.');
    $assert(substr_count($radioHtml, '<label for="choice_') === 2 && substr_count($radioHtml, '<div class="field-inner-wrapper"><input') === 2, 'Each wrapped radio must render its input inside an inner wrapper within a label.');
    $assert(str_contains($radioHtml, '<label for="choice_0"><div class="field-inner-wrapper"><input') && str_contains($radioHtml, 'id="choice_0"') && str_contains($radioHtml, 'id="choice_1"'), 'Radio labels must pair an explicit for with the input id while nesting the input.');
    $assert(str_contains($radioHtml, '</div><div class="field-inner-label-wrapper"><span class="fld-label-header">Option A</span>'), 'A wrapped radio must render its label block after the input.');
    $radioRaw = $radioGroup->compileAsHtmlStringUnwrapped();
    $assert(!str_contains($radioRaw, 'field-wrapper') && substr_count($radioRaw, '<div class="radio-wrapper"><label for="choice_') === 2 && substr_count($radioRaw, '</label></div>') === 2, 'A raw radio group must render closed radio-wrapper labels with an explicit for.');
    $ownIdRadio = (new \MvpLounge\MeshFactory\Element\Field\InputRadio())->addName('pick')->addCheckedElements([['value' => 'x', 'label' => 'X', 'id' => 'custom_x']]);
    $assert(str_contains($ownIdRadio->compileAsHtmlString(), '<label for="custom_x">'), 'A radio with its own id must keep it for the explicit for.');

    $hidden = (new \MvpLounge\MeshFactory\Element\Field\InputHidden())->addName('token')->addValue('abc')->addLabel('Ignored');
    $assert($hidden->compileAsHtmlString() === $hidden->getElementOpen() && $hidden->string() === $hidden->getElementOpen(), 'A hidden field must render bare by default.');
    ob_start();
    $hidden->build();
    $assert(preg_replace('/\s*\n\t/', '', (string) ob_get_clean()) === $hidden->getElementOpen(), 'A hidden field build() must echo the bare input.');
    $hiddenInFieldset = $hidden->addFieldset(['label' => 'Mixed'])->compileAsHtmlStringWithFieldset();
    $assert(str_contains($hiddenInFieldset, '<div class="field-wrapper hidden" data-field="token">') && str_starts_with($hiddenInFieldset, '<fieldset'), 'A hidden field in a fieldset must take the wrapped structure.');

    $fieldsetField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('combo')->addLabel('Combo')->addFieldset(['label' => 'Contact']);
    $assert($fieldsetField->compileAsHtmlStringWithFieldset() === '<fieldset class="generic-fieldset"><label>Contact</label>' . $fieldsetField->compileAsHtmlString() . '</fieldset>', 'The fieldset variant must wrap the wrapped default.');
    $assert($fieldsetField->compileAsHtmlStringUnwrappedWithFieldset() === '<fieldset class="generic-fieldset"><label>Contact</label>' . $fieldsetField->compileAsHtmlStringUnwrapped() . '</fieldset>', 'The raw fieldset variant must wrap the raw output.');
    ob_start();
    $fieldsetField->buildWithFieldset();
    $assert(substr_count((string) ob_get_clean(), '</label>') === 2, 'buildWithFieldset() must close the fieldset label and the field label exactly once each.');

    $fieldset = new \MvpLounge\MeshFactory\Element\Form\Fieldset();
    $assert($fieldset->addLegend(' Details & options ') === $fieldset, 'addLegend() must remain fluent.');
    $fieldset->addField('PRIMARY', $firstField)->addField('primary', $replacementField, false);
    $fieldset->addFieldCollection(['secondary' => $secondField, 'invalid' => 'not a field']);
    $content = $fieldset->getElementContent();
    $assert(str_contains($content, '<legend>Details &amp; options</legend>'), 'The legend must be trimmed and escaped.');
    $assert(str_contains($content, 'name="first"') && str_contains($content, 'name="second"'), 'The fieldset must render its fields.');
    $assert(!str_contains($content, 'name="replacement"'), 'A non-overriding duplicate must preserve the original field.');
    $fieldset->addField('primary', $replacementField);
    $assert(str_contains($fieldset->getElementContent(), 'name="replacement"'), 'An overriding duplicate must replace the original field.');
    $assert(!str_contains($fieldset->getElementContent(), 'name="first"'), 'A replaced field must no longer render.');
    $assert($fieldset->compileAsArray()['fields'] === $fieldset->getElementContent(), 'Array output must contain fieldset content.');
    $assert(!method_exists($fieldset, 'compile'), 'The compile() alias must be removed in favor of compileAsArray().');
    $assert(str_contains($fieldset->compileAsHtmlString(), $fieldset->getElementContent()), 'HTML output must contain the fieldset content.');
    $assert($fieldset->string() === $fieldset->compileAsHtmlString(), 'string() must match fieldset HTML output.');
    ob_start();
    $fieldset->build();
    $built = ob_get_clean();
    $assert(str_contains($built, $fieldset->getElementContent()), 'build() must render the fieldset content.');
    $fieldset->addLegend(NULL);
    $assert(!str_contains($fieldset->getElementContent(), '<legend>'), 'A null legend must clear the legend.');
    $configuredFieldset = (new \MvpLounge\MeshFactory\Element\Form\Fieldset())->configureFactory(['legend' => 'Configured']);
    $assert(str_contains($configuredFieldset->getElementContent(), '<legend>Configured</legend>'), 'Configuration must set the legend.');

    $labelledFieldset = new \MvpLounge\MeshFactory\Element\Form\Fieldset(['id' => 'fs_label', 'label' => 'Contact']);
    $assert($labelledFieldset->getElementLabel() === '<label>Contact</label>', 'A string label must render as a FieldsetLabel.');
    $assert($labelledFieldset->getLabel() instanceof \MvpLounge\MeshFactory\Element\Form\FieldsetLabel, 'The fieldset must store a FieldsetLabel element.');
    $assert(str_contains($labelledFieldset->getElementContent(), '<label>Contact</label>'), 'The label must render inside the fieldset content.');
    $assert($labelledFieldset->compileAsArray()['label'] === '<label>Contact</label>', 'Array output must contain the label.');
    $assert($labelledFieldset->addLabel(NULL)->getElementLabel() === NULL, 'A null label must clear the label.');
    $assert($labelledFieldset->addClass('extra')->getElementOpen() === '<fieldset id="fs_label" class="extra generic-fieldset">', 'The fieldset must render user and system classes.');

    $labelledField = (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('contact')->addFieldset(['label' => 'Contact']);
    $assert(str_contains($labelledField->compileAsHtmlStringWithFieldset(), '<fieldset class="generic-fieldset"><label>Contact</label>'), 'A field fieldset must render its label after the opening tag.');

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}