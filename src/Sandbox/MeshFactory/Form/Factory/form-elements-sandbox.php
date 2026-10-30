<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;

echo '=== Form Sandbox (Factory) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-factory-sandbox-template.md

$runAllPath = realpath(__DIR__ . '/../../run-all.php') ?: (__DIR__ . '/../../run-all.php');
$singlePath = realpath(__FILE__) ?: __FILE__;
echo 'DEBUG_RUN_ALL: ' . $runAllPath . PHP_EOL;
echo 'DEBUG_SINGLE: ' . $singlePath . PHP_EOL;

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

    $globalFormParams = static function (string $suffix): array {
        return [
            'id' => 'form_' . $suffix,
            'class' => 'form-usecase form-' . $suffix,
            'title' => 'Form use case: ' . $suffix,
            'style' => 'display:block',
            'lang' => 'en',
            'dir' => 'ltr',
            'hidden' => 'hidden',
            'tabindex' => 1,
            'draggable' => 'false',
            'contenteditable' => 'false',
            'spellcheck' => 'false',
            'translate' => 'no',
            'role' => 'form',
            'aria-label' => $suffix . ' form',
            'aria-labelledby' => 'label_' . $suffix,
            'aria-describedby' => 'help_' . $suffix
        ];
    };

    $makeTextField = static function (string $name, string $label, string $placeholder, array $extra = []): \MvpLounge\MeshFactory\Element\Field\TextInput {
        $field = new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge([
            'name' => $name,
            'label' => $label,
            'placeholder' => $placeholder,
            'value' => '',
            'fieldset' => [
                'id' => 'fieldset_' . $name,
                'user' => ['field-group', 'field-' . $name],
            ],
        ], $extra));

        $field->addName($name)
            ->addPlaceholder($placeholder)
            ->addType('text')
            ->addValue('')
            ->addAccess(true);

        return $field;
    };

    $makePasswordField = static function (string $name, string $label): \MvpLounge\MeshFactory\Element\Field\PasswordInput {
        return new \MvpLounge\MeshFactory\Element\Field\PasswordInput([
            'name' => $name,
            'label' => $label,
            'fieldset' => [
                'id' => 'fieldset_' . $name,
                'user' => ['field-group', 'field-' . $name],
            ],
        ]);
    };

    $makePayload = static function (object $factory): string {
        return $factory->compileAsJson() ?? '';
    };

    $cases = [
        'LoginForm' => static function () use ($globalFormParams, $makeTextField, $makePasswordField): array {
            $factory = (new \MvpLounge\MeshFactory\Element\Form\PostForm($globalFormParams('login')))
                ->addAction('/account/login')
                ->addMethod('post')
                ->addNoValidate('novalidate')
                ->addTarget(FactoryElementWindowTarget::SELF->value)
                ->addAutoComplete('on')
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'login-token'])
                ->addFormSectionFields('credentials', 'email', $makeTextField('email', 'Email address', 'name@example.com'))
                ->addFormSectionFields('credentials', 'password', $makePasswordField('password', 'Password'))
                ->addFormSubmitButton('Sign in');

            return [$factory, ['/account/login', 'email', 'password', 'Sign in', 'csrf_token']];
        },
        'RegistrationForm' => static function () use ($globalFormParams, $makeTextField, $makePasswordField): array {
            $factory = (new \MvpLounge\MeshFactory\Element\Form\PostForm($globalFormParams('registration')))
                ->addAction('/account/register')
                ->addMethod('post')
                ->addEnc('multipart/form-data')
                ->addNoValidate('novalidate')
                ->addTarget(FactoryElementWindowTarget::SELF->value)
                ->addAutoComplete('on')
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'registration-token'])
                ->addHiddenPostField(['name' => 'account_type', 'value' => 'basic'])
                ->addFormSectionFields('identity', 'first_name', $makeTextField('first_name', 'First name', 'Ada'))
                ->addFormSectionFields('identity', 'last_name', $makeTextField('last_name', 'Last name', 'Lovelace'))
                ->addFormSectionFields('identity', 'email', $makeTextField('email', 'Email address', 'name@example.com'))
                ->addFormSectionFields('security', 'password', $makePasswordField('password', 'Password'))
                ->addFormSectionFields('security', 'confirm_password', $makePasswordField('confirm_password', 'Confirm password'))
                ->addFormSubmitButton('Create account');

            return [$factory, ['/account/register', 'first_name', 'last_name', 'confirm_password', 'Create account', 'multipart/form-data']];
        },
        'AddressForm' => static function () use ($globalFormParams, $makeTextField): array {
            $factory = (new \MvpLounge\MeshFactory\Element\Form\PostForm($globalFormParams('address')))
                ->addAction('/account/address')
                ->addMethod('post')
                ->addNoValidate('novalidate')
                ->addTarget(FactoryElementWindowTarget::SELF->value)
                ->addAutoComplete('on')
                ->addHiddenPostField(['name' => 'address_id', 'value' => 'primary'])
                ->addFormSectionFields('address', 'street_1', $makeTextField('street_1', 'Street 1', '123 Main Street'))
                ->addFormSectionFields('address', 'street_2', $makeTextField('street_2', 'Street 2', 'Apartment, suite, unit'))
                ->addFormSectionFields('address', 'city', $makeTextField('city', 'City', 'Seattle'))
                ->addFormSectionFields('address', 'region', $makeTextField('region', 'State / Region', 'WA'))
                ->addFormSectionFields('address', 'postal_code', $makeTextField('postal_code', 'Postal code', '98101'))
                ->addFormSectionFields('address', 'country', $makeTextField('country', 'Country', 'United States'))
                ->addFormSubmitButton('Save address');

            return [$factory, ['/account/address', 'street_1', 'postal_code', 'Save address', 'address_id']];
        },
        'ProfileUpdateAjaxForm' => static function () use ($globalFormParams, $makeTextField): array {
            $factory = (new \MvpLounge\MeshFactory\Element\Form\AjaxForm($globalFormParams('profile-update')))
                ->addAction('/api/account/profile')
                ->addMethod('post')
                ->addEnc('multipart/form-data')
                ->addNoValidate('novalidate')
                ->addTarget(FactoryElementWindowTarget::BLANK->value)
                ->addAutoComplete('on')
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'profile-token'])
                ->addHiddenPostField(['name' => 'mode', 'value' => 'ajax'])
                ->addFormSectionFields('profile', 'display_name', $makeTextField('display_name', 'Display name', 'Mvp Lounge'))
                ->addFormSectionFields('profile', 'phone', $makeTextField('phone', 'Phone number', '+1 555 0100'))
                ->addFormSectionFields('profile', 'avatar', $makeTextField('avatar', 'Avatar path', '/images/avatar.png'))
                ->addFormSubmitButton('Update profile');

            return [$factory, ['/api/account/profile', 'display_name', 'phone', 'avatar', 'Update profile', FactoryElementWindowTarget::BLANK->value]];
        }
    ];

    foreach ($cases as $label => $builder) {
        [$factory, $expected] = $builder();
        $payload = $makePayload($factory);
        echo '-- ' . $label . ' compileAsJson() --' . PHP_EOL;
        var_dump($payload);
        $assert(is_string($payload) && $payload !== '', $label . ' compileAsJson() must return rendered markup payload.');
        foreach ($expected as $fragment) {
            $assert(str_contains($payload, $fragment), $label . ' missing fragment: ' . $fragment . ' in ' . $payload);
        }
    }

    echo 'PASS assertions' . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'DEBUG_RUN_ALL: ' . $runAllPath . PHP_EOL;
    echo 'DEBUG_SINGLE: ' . $singlePath . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;

    #endregion

    exit(1);
}