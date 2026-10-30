<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use MvpLounge\MeshFactory\Enum\FactoryElementWindowTarget;

echo '=== Form Sandbox (Params) ===' . PHP_EOL;

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
            'id' => 'form_id_' . $suffix,
            'class' => 'form-class-' . $suffix,
            'title' => 'form_title_' . $suffix,
            'style' => 'display:block',
            'lang' => 'en',
            'dir' => 'ltr',
            'hidden' => 'hidden',
            'tabindex' => 4,
            'draggable' => 'false',
            'contenteditable' => 'false',
            'spellcheck' => 'false',
            'translate' => 'no',
            'role' => 'form',
            'aria-label' => 'form_aria_label_' . $suffix,
            'aria-labelledby' => 'form_aria_labelledby_' . $suffix,
            'aria-describedby' => 'form_aria_describedby_' . $suffix
        ];
    };

    $makePayload = static function (object $factory): string {
        return $factory->compileAsJson() ?? '';
    };

    $cases = [
        'LoginForm' => static function () use ($globalParams): array {
            // Agent or Human:
            //
            // Manage logic to instantiate the factory
            //
    
            $factory = new \MvpLounge\MeshFactory\Element\Form\PostForm(array_merge($globalParams('login'), [
                'action' => '/account/login',
                'method' => 'post',
                'enctype' => 'application/x-www-form-urlencoded',
                'novalidate' => 'novalidate',
                'target' => FactoryElementWindowTarget::SELF->value,
                'autocomplete' => 'on',
            ]));

            $factory
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'login-token'])
                ->addFormSectionFields('credentials', 'email', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('login_email'), [
                    'name' => 'email',
                    'label' => 'Email address',
                    'placeholder' => 'name@example.com',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_login_email',
                        'user' => ['field-group', 'field-login-email'],
                    ],
                ])))
                ->addFormSectionFields('credentials', 'password', new \MvpLounge\MeshFactory\Element\Field\PasswordInput(array_merge($globalParams('login_password'), [
                    'name' => 'password',
                    'label' => 'Password',
                    'fieldset' => [
                        'id' => 'fieldset_login_password',
                        'user' => ['field-group', 'field-login-password'],
                    ],
                ])))
                ->addFormSubmitButton('Sign in');

            return [$factory, ['/account/login', 'email', 'password', 'Sign in', 'csrf_token']];
        },
        'RegistrationForm' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Form\PostForm(array_merge($globalParams('registration'), [
                'action' => '/account/register',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'novalidate' => 'novalidate',
                'target' => FactoryElementWindowTarget::SELF->value,
                'autocomplete' => 'on',
            ]));

            $factory
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'registration-token'])
                ->addHiddenPostField(['name' => 'account_type', 'value' => 'basic'])
                ->addFormSectionFields('identity', 'first_name', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('first_name'), [
                    'name' => 'first_name',
                    'label' => 'First name',
                    'placeholder' => 'Ada',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_registration_first_name',
                        'user' => ['field-group', 'field-registration-first-name'],
                    ],
                ])))
                ->addFormSectionFields('identity', 'last_name', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('last_name'), [
                    'name' => 'last_name',
                    'label' => 'Last name',
                    'placeholder' => 'Lovelace',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_registration_last_name',
                        'user' => ['field-group', 'field-registration-last-name'],
                    ],
                ])))
                ->addFormSectionFields('identity', 'email', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('registration_email'), [
                    'name' => 'email',
                    'label' => 'Email address',
                    'placeholder' => 'name@example.com',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_registration_email',
                        'user' => ['field-group', 'field-registration-email'],
                    ],
                ])))
                ->addFormSectionFields('security', 'password', new \MvpLounge\MeshFactory\Element\Field\PasswordInput(array_merge($globalParams('registration_password'), [
                    'name' => 'password',
                    'label' => 'Password',
                    'fieldset' => [
                        'id' => 'fieldset_registration_password',
                        'user' => ['field-group', 'field-registration-password'],
                    ],
                ])))
                ->addFormSectionFields('security', 'confirm_password', new \MvpLounge\MeshFactory\Element\Field\PasswordInput(array_merge($globalParams('registration_confirm_password'), [
                    'name' => 'confirm_password',
                    'label' => 'Confirm password',
                    'fieldset' => [
                        'id' => 'fieldset_registration_confirm_password',
                        'user' => ['field-group', 'field-registration-confirm-password'],
                    ],
                ])))
                ->addFormSubmitButton('Create account');

            return [$factory, ['/account/register', 'first_name', 'last_name', 'confirm_password', 'Create account', 'multipart/form-data']];
        },
        'AddressForm' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Form\PostForm(array_merge($globalParams('address'), [
                'action' => '/account/address',
                'method' => 'post',
                'novalidate' => 'novalidate',
                'target' => FactoryElementWindowTarget::SELF->value,
                'autocomplete' => 'on',
            ]));

            $factory
                ->addHiddenPostField(['name' => 'address_id', 'value' => 'primary'])
                ->addFormSectionFields('address', 'street_1', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('street_1'), [
                    'name' => 'street_1',
                    'label' => 'Street 1',
                    'placeholder' => '123 Main Street',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_street_1',
                        'user' => ['field-group', 'field-address-street-1'],
                    ],
                ])))
                ->addFormSectionFields('address', 'street_2', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('street_2'), [
                    'name' => 'street_2',
                    'label' => 'Street 2',
                    'placeholder' => 'Apartment, suite, unit',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_street_2',
                        'user' => ['field-group', 'field-address-street-2'],
                    ],
                ])))
                ->addFormSectionFields('address', 'city', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('city'), [
                    'name' => 'city',
                    'label' => 'City',
                    'placeholder' => 'Seattle',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_city',
                        'user' => ['field-group', 'field-address-city'],
                    ],
                ])))
                ->addFormSectionFields('address', 'region', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('region'), [
                    'name' => 'region',
                    'label' => 'State / Region',
                    'placeholder' => 'WA',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_region',
                        'user' => ['field-group', 'field-address-region'],
                    ],
                ])))
                ->addFormSectionFields('address', 'postal_code', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('postal_code'), [
                    'name' => 'postal_code',
                    'label' => 'Postal code',
                    'placeholder' => '98101',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_postal_code',
                        'user' => ['field-group', 'field-address-postal-code'],
                    ],
                ])))
                ->addFormSectionFields('address', 'country', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('country'), [
                    'name' => 'country',
                    'label' => 'Country',
                    'placeholder' => 'United States',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_address_country',
                        'user' => ['field-group', 'field-address-country'],
                    ],
                ])))
                ->addFormSubmitButton('Save address');

            return [$factory, ['/account/address', 'street_1', 'postal_code', 'Save address', 'address_id']];
        },
        'ProfileUpdateAjaxForm' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Form\AjaxForm(array_merge($globalParams('profile_update'), [
                'action' => '/api/account/profile',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'novalidate' => 'novalidate',
                'target' => FactoryElementWindowTarget::BLANK->value,
                'autocomplete' => 'on',
            ]));

            $factory
                ->addHiddenPostField(['name' => 'csrf_token', 'value' => 'profile-token'])
                ->addHiddenPostField(['name' => 'mode', 'value' => 'ajax'])
                ->addFormSectionFields('profile', 'display_name', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('display_name'), [
                    'name' => 'display_name',
                    'label' => 'Display name',
                    'placeholder' => 'Mvp Lounge',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_profile_display_name',
                        'user' => ['field-group', 'field-profile-display-name'],
                    ],
                ])))
                ->addFormSectionFields('profile', 'phone', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('phone'), [
                    'name' => 'phone',
                    'label' => 'Phone number',
                    'placeholder' => '+1 555 0100',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_profile_phone',
                        'user' => ['field-group', 'field-profile-phone'],
                    ],
                ])))
                ->addFormSectionFields('profile', 'avatar', new \MvpLounge\MeshFactory\Element\Field\TextInput(array_merge($globalParams('avatar'), [
                    'name' => 'avatar',
                    'label' => 'Avatar path',
                    'placeholder' => '/images/avatar.png',
                    'value' => '',
                    'fieldset' => [
                        'id' => 'fieldset_profile_avatar',
                        'user' => ['field-group', 'field-profile-avatar'],
                    ],
                ])))
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