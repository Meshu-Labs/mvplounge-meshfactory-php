<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Field Sandbox (Params) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-params-sandbox-template.md


try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $assert = static function (bool $condition, string $message): void {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    };

    $globalParams = static function (string $suffix): array {
        return [
            'id' => 'field_id_' . $suffix,
            'class' => 'field-class-' . $suffix,
            'title' => 'field_title_' . $suffix,
            'style' => 'display:block',
            'lang' => 'en',
            'dir' => 'ltr',
            'hidden' => 'hidden',
            'tabindex' => 2,
            'draggable' => 'true',
            'contenteditable' => 'true',
            'spellcheck' => 'true',
            'translate' => 'yes',
            'role' => 'textbox',
            'aria-label' => 'field_aria_label_' . $suffix,
            'aria-labelledby' => 'field_aria_labelledby_' . $suffix,
            'aria-describedby' => 'field_aria_describedby_' . $suffix
        ];
    };

    $globalExpected = static function (string $suffix): array {
        return [
            'field_id_' . $suffix,
            'field-class-' . $suffix,
            'title="field_title_' . $suffix . '"',
            'style="display:block"',
            'lang="en"',
            'dir="ltr"',
            'hidden="hidden"',
            'tabindex="2"',
            'draggable="true"',
            'contenteditable="true"',
            'spellcheck="true"',
            'translate="yes"',
            'role="textbox"',
            'aria-label="field_aria_label_' . $suffix . '"',
            'aria-labelledby="field_aria_labelledby_' . $suffix . '"',
            'aria-describedby="field_aria_describedby_' . $suffix . '"'
        ];
    };

    $assertContainsAll = static function (string $label, string $html, array $expected) use ($assert): void {
        foreach ($expected as $fragment) {
            $assert(str_contains($html, $fragment), $label . ' missing fragment: ' . $fragment . ' in ' . $html);
        }
    };

    $cases = [
        'InputText' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'text';
            $params = array_merge($globalParams($suffix), [
                'name' => 'text_name',
                'placeholder' => 'Text placeholder',
                'type' => 'text',
                'value' => 'text_value',
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\InputText($params), array_merge($globalExpected($suffix), ['name="text_name"', 'placeholder="Text placeholder"', 'type="text"', 'value="text_value"', 'enabled'])];
        },
        'InputEmailer' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'email';
            $params = array_merge($globalParams($suffix), [
                'name' => 'email_name',
                'placeholder' => 'name@example.com',
                'type' => 'email',
                'value' => 'name@example.com',
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\InputEmailer($params), array_merge($globalExpected($suffix), ['name="email_name"', 'placeholder="name@example.com"', 'type="email"', 'value="name@example.com"', 'enabled'])];
        },
        'FormButton' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'button';
            $params = array_merge($globalParams($suffix), [
                'name' => 'button_name',
                'type' => 'submit',
                'value' => 'Submit',
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\FormButton($params), array_merge($globalExpected($suffix), ['name="button_name"', 'type="submit"', 'value="Submit"', 'enabled'])];
        },
        'InputHidden' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'hidden';
            $params = array_merge($globalParams($suffix), [
                'name' => 'hidden_name',
                'type' => 'hidden',
                'value' => 'hidden_value',
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\InputHidden($params), array_merge($globalExpected($suffix), ['name="hidden_name"', 'type="hidden"', 'value="hidden_value"', 'enabled'])];
        },
        'InputPassword' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'password';
            $params = array_merge($globalParams($suffix), [
                'name' => 'password_name',
                'type' => 'password',
                'value' => 'secret',
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\InputPassword($params), array_merge($globalExpected($suffix), ['name="password_name"', 'type="password"', 'value="secret"', 'enabled'])];
        },
        'InputRadio' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'radio';
            $params = array_merge($globalParams($suffix), [
                'name' => 'radio_name',
                'type' => 'radio',
                'value' => 'radio_value',
                'checked' => true,
                'access' => true,
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\InputRadio($params), array_merge($globalExpected($suffix), ['name="radio_name"', 'type="radio"', 'value="radio_value"', 'checked', 'enabled'])];
        },
        'SelectOption' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'select';
            $params = array_merge($globalParams($suffix), [
                'name' => 'select_name',
                'value' => 2,
                'access' => true,
            ]);
            // Agent or Human:
            //
            // Manage logic to instantiate the factory
            //
    
            $factory = new \MvpLounge\MeshFactory\Element\Field\SelectOption($params);
            $factory->addOptions([1 => 'One', 2 => 'Two']);
            return [$factory, array_merge($globalExpected($suffix), ['name="select_name"', 'value="2"', 'enabled', 'selected', '>Two<'])];
        },
        'SelectOptions' => static function () use ($globalParams, $globalExpected): array {
            $suffix = 'option';
            $params = array_merge($globalParams($suffix), [
                'value' => 2,
                'selected' => true,
                'content' => 'Two',
            ]);
            return [new \MvpLounge\MeshFactory\Element\Field\SelectOptions($params), array_merge($globalExpected($suffix), ['value="2"', 'selected', '>Two<'])];
        }
    ];

    foreach ($cases as $label => $builder) {
        [$factory, $expected] = $builder();
        $html = $factory->compileAsHtmlString();
        echo '-- ' . $label . ' compileAsHtmlString() --' . PHP_EOL;
        var_dump($html);
        $assert(is_string($html) && $html !== '', $label . ' compileAsHtmlString() must return rendered markup.');
        $assertContainsAll($label, $html, $expected);
    }

    echo 'PASS assertions' . PHP_EOL;
    #endregion

} catch (Throwable $e) {

    #region Error Handling

    // Agent or Human:
    //
    // Emit error diagnostic messages - customize after generation
    //

    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);

    #endregion
}