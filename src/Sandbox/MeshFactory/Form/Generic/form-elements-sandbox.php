<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Form Sandbox (Generic) ===' . PHP_EOL;

try {
    $assert = static function (bool $condition, string $message): void {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    };

    $factories = [
        'FormPost' => new \MvpLounge\MeshFactory\Element\Form\FormPost(),
        'FormAjax' => new \MvpLounge\MeshFactory\Element\Form\FormAjax(),
        'InputButton' => new \MvpLounge\MeshFactory\Element\Form\InputButton(),
        'Datalist' => new \MvpLounge\MeshFactory\Element\Form\Datalist(),
        'FieldsetLabel' => new \MvpLounge\MeshFactory\Element\Form\FieldsetLabel(),
        'Legend' => new \MvpLounge\MeshFactory\Element\Form\Legend(),
        'Meter' => new \MvpLounge\MeshFactory\Element\Form\Meter(),
        'Optgroup' => new \MvpLounge\MeshFactory\Element\Form\Optgroup(),
        'Output' => new \MvpLounge\MeshFactory\Element\Form\Output(),
        'Fieldset' => new \MvpLounge\MeshFactory\Element\Form\Fieldset(),
        'Progress' => new \MvpLounge\MeshFactory\Element\Form\Progress()
    ];

    foreach ($factories as $label => $factory) {
        $assert($factory->addClass('generic-' . strtolower($label)) === $factory, $label . ' addClass() must remain fluent.');
        $html = $factory->compileAsHtmlString();
        echo '-- ' . $label . ' compileAsHtmlString() --' . PHP_EOL;
        var_dump($html);
        $assert(is_string($html), $label . ' compileAsHtmlString() must return a string.');
    }

    foreach (['_SELF' => '_self', '_BLANK' => '_blank', '_PARENT' => '_parent', '_TOP' => '_top'] as $target => $expected) {
        $form = (new \MvpLounge\MeshFactory\Element\Form\FormPost())->addTarget($target);
        $assert(str_contains($form->getElementOpen(), 'target="' . $expected . '"'), 'Form targets must render in lowercase: ' . $target);
    }

    $form = new \MvpLounge\MeshFactory\Element\Form\FormPost();
    $form->addHiddenPostField(['name' => 'token', 'value' => 'sample']);
    $form->addFormSectionFields('main', 'email', (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('email')->addLabel('Email'));
    $form->addFormSubmitButton('Submit');
    $prepared = $form->prepareFactoryModel();
    $assert(str_contains(implode('', $prepared['hidden']), 'name="token"'), 'The form must render its hidden field.');
    $assert(str_contains($prepared['fields']['main']['email'], '<label><div class="field-inner-label-wrapper"><span class="fld-label-header">Email</span>'), 'The form must render the field inside its label.');
    $assert(str_starts_with($prepared['fields']['main']['email'], '<div class="field-wrapper text" data-field="email">'), 'The form must render fields with the wrapped default.');
    ob_start();
    $form->buildFormHiddenPostVars();
    $builtHidden = (string) ob_get_clean();
    $assert(str_contains($builtHidden, 'name="token"') && !str_contains($builtHidden, 'field-wrapper'), 'Form hidden post variables must render as bare inputs.');
    $assert(str_contains($prepared['buttons'], 'Submit'), 'The form must render its submit button.');
    $assert(!method_exists($form, 'compile') && !method_exists($form, 'prepare'), 'The compile() and prepare() names must be removed.');
    $assert(str_contains($prepared['fieldsets']['main']['open'], 'id="fieldset_section_main"'), 'The section fieldset must expose its opening tag.');
    $assert(str_contains($prepared['fieldsets']['main']['open'], 'class="col full generic-fieldset"'), 'The section fieldset must render its default classes.');
    $assert($form->getFormSectionFieldset('main') === $form->getFormSectionFieldset('MAIN'), 'Section keys must be case-insensitive.');
    $assert($form->getFormResetButton() !== NULL && is_array($form->compileFormResetButtonAsArray()), 'compileFormResetButtonAsArray() must return the reset button model.');

    $form->addFormSectionFieldsetLabel('main', 'Account')->addFormSectionFieldsetClass('main', 'wide');
    $form->addFormSectionFields('main', 'name', (new \MvpLounge\MeshFactory\Element\Field\InputText())->addName('name'), ['id' => 'fs_main']);
    $sectionFieldset = $form->compileAsArray()['fieldsets']['main'];
    $assert($sectionFieldset['label'] === '<label>Account</label>', 'The section fieldset must store and render its label.');
    $assert($sectionFieldset['open'] === '<fieldset id="fs_main" class="col full wide generic-fieldset">', 'Fieldset params passed to addFormSectionFields() must merge into the section fieldset.');
    $assert(array_keys($form->getFormFields()['main']) === ['email', 'name'], 'getFormFields() must list only fields, keyed by namespace.');
    ob_start();
    $form->buildFormSectionFields('main');
    $builtSection = ob_get_clean();
    $assert(str_contains($builtSection, '<fieldset id="fs_main"') && str_contains($builtSection, '<label>Account</label>') && str_contains($builtSection, 'name="name"'), 'buildFormSectionFields() must render the fieldset, label, and fields.');

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}