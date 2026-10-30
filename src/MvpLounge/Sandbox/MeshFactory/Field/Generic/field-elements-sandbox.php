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
        'TextInput' => new \MvpLounge\MeshFactory\Element\Field\TextInput(),
        'EmailerInput' => new \MvpLounge\MeshFactory\Element\Field\EmailerInput(),
        'FormButton' => new \MvpLounge\MeshFactory\Element\Field\FormButton(),
        'HiddenInput' => new \MvpLounge\MeshFactory\Element\Field\HiddenInput(),
        'PasswordInput' => new \MvpLounge\MeshFactory\Element\Field\PasswordInput(),
        'RadioInput' => new \MvpLounge\MeshFactory\Element\Field\RadioInput(),
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

    $firstField = (new \MvpLounge\MeshFactory\Element\Field\TextInput())->addName('first')->addLabel('First');
    $replacementField = (new \MvpLounge\MeshFactory\Element\Field\TextInput())->addName('replacement');
    $secondField = (new \MvpLounge\MeshFactory\Element\Field\TextInput())->addName('second');
    $fieldHtml = $firstField->compileAsHtmlString();
    $assert(str_contains($fieldHtml, '<label>First<input'), 'The label must wrap the input.');
    $assert(str_contains($fieldHtml, '</label>'), 'The label must close after the input.');

    $fieldset = new \MvpLounge\MeshFactory\Abstract\FactoryElementFieldsetAbstract();
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
    $assert($fieldset->compile() === $fieldset->compileAsArray(), 'compile() must return the fieldset array.');
    $assert(str_contains($fieldset->compileAsHtmlString(), $fieldset->getElementContent()), 'HTML output must contain the fieldset content.');
    $assert($fieldset->string() === $fieldset->compileAsHtmlString(), 'string() must match fieldset HTML output.');
    ob_start();
    $fieldset->build();
    $built = ob_get_clean();
    $assert(str_contains($built, $fieldset->getElementContent()), 'build() must render the fieldset content.');
    $fieldset->addLegend(NULL);
    $assert(!str_contains($fieldset->getElementContent(), '<legend>'), 'A null legend must clear the legend.');
    $configuredFieldset = (new \MvpLounge\MeshFactory\Abstract\FactoryElementFieldsetAbstract())->configureFactory(['legend' => 'Configured']);
    $assert(str_contains($configuredFieldset->getElementContent(), '<legend>Configured</legend>'), 'Configuration must set the legend.');

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}