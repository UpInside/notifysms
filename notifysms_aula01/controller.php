<?php
/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 12/07/2018
 * Time: 10:43
 */

require_once __DIR__ . '/config.php';

$postData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$action = $postData['action'];
unset($postData['action']);

switch ($action) {
    case 'add_user':

        $user = new \Source\Models\User;

        $response = $user->addUser($postData['user_name'], $postData['user_email'], $postData['user_password'], $postData['user_phone']);

        if ($response === false) {
            $json['add_user'] = false;
        } else {
            $json['add_user'] = true;
        }

        break;

    case 'validate_code':

        $user = new \Source\Models\User;

        $response = $user->validateCode($postData['user_email'], $postData['user_code']);

        if ($response === false) {
            $json['validate'] = false;
        } else {
            $json['validate'] = true;
        }

        break;
}

echo json_encode($json);