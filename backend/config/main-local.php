<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'huGHy3p-Ito4eafzoG3h9Kt8Da68ZdgU',
        ],
    ],
];

if (!YII_ENV_TEST) {
}

return $config;
