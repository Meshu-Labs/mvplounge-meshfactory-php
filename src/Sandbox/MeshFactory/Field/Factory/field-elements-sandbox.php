<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Field Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

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

    $cases = [
        'InputText' => static function () {
                    $factory = new \MvpLounge\MeshFactory\Element\Field\InputText();
            $factory->addName('text_name')->addPlaceholder('Text placeholder')->addType('text')->addValue('text_value')->addAccess(true);
            return $factory;
        },
        'InputEmailer' => static function () {
                    $factory = new \MvpLounge\MeshFactory\Element\Field\InputEmailer();
            $factory->addName('email_name')->addPlaceholder('name@example.com')->addValue('name@example.com')->addAccess(true);
            return $factory;
        },
        'FormButton' => static function () {
            $factory = new \MvpLounge\MeshFactory\Element\Field\FormButton();
            $factory->addName('button_name')->addValue('Submit')->asSubmit()->addAccess(true);
            return $factory;
        },
        'InputHidden' => static function () {
                    $factory = new \MvpLounge\MeshFactory\Element\Field\InputHidden();
            $factory->addName('hidden_name')->addValue('hidden_value')->addAccess(true);
            return $factory;
        },
        'InputPassword' => static function () {
                    $factory = new \MvpLounge\MeshFactory\Element\Field\InputPassword();
            $factory->addName('password_name')->addLabel('Password')->addValue('secret')->addAccess(true);
            return $factory;
        },
        'InputRadio' => static function () {
                    $factory = new \MvpLounge\MeshFactory\Element\Field\InputRadio();
            $factory->addName('radio_name')->addValue('radio_value')->addChecked(true)->addAccess(true);
            return $factory;
        },
        'SelectOption' => static function () {
            $factory = new \MvpLounge\MeshFactory\Element\Field\SelectOption();
            $factory->addName('select_name')->addValue(2)->addAccess(true)->addOptions([1 => 'One', 2 => 'Two']);
            return $factory;
        },
        'SelectOptions' => static function () {
            $factory = new \MvpLounge\MeshFactory\Element\Field\SelectOptions();
            $factory->addValue(2)->selected()->addContent('Two');
            return $factory;
        }
    ];

    foreach ($cases as $label => $builder) {
        $factory = $builder();
        echo '-- ' . $label . ' compileAsHtmlString() --' . PHP_EOL;
        $html = $factory->compileAsHtmlString();
        var_dump($html);
        $assert(is_string($html) && $html !== '', $label . ' compileAsHtmlString() must return rendered markup.');
    }

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;

    #endregion

    exit(1);
}