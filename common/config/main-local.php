<?php

$host = 'us-cdbr-iron-east-03.cleardb.net';
$username = 'b1f73c49d6c869';
$password = 'ad39206f';
$dbname = 'heroku_ceefc16cb03a2ff';


$host = 'localhost';
$dbname = 'nsign';
$username = 'root';
$password = '1';



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