<?php

$host = 'us-cdbr-iron-east-03.cleardb.net';
$username = 'b44ea332aefeaa';
$password = '12b25153';
$dbname = 'heroku_0550212b5359996';

/*$host = 'localhost';
$dbname = 'nsign';
$username = 'root';
$password = '1';*/

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.$host.';dbname='.$dbname,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];