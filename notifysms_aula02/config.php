<?php
/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 11/07/2018
 * Time: 17:14
 */

define('DATABASE', [
    'USER' => 'root',
    'PASS' => '',
    'HOST' => 'localhost',
    'NAME' => 'play_notifysms'
]);

require_once __DIR__ . '/source/crud/Conn.php';
require_once __DIR__ . '/source/crud/Create.php';
require_once __DIR__ . '/source/crud/Read.php';
require_once __DIR__ . '/source/crud/Update.php';

require_once __DIR__ . '/source/models/User.php';

define('CONFIG_SMS', [
    'CLIENT_ID' => '',
    'CLIENT_SECRET' => '',
    'GUHWEB' => ''
]);

require_once __DIR__ . '/source/notify/sms/DirectCall.php';
