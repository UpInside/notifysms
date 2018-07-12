<?php
/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 12/07/2018
 * Time: 11:04
 */

namespace Source\Models;

use CRUD\Create;
use CRUD\Read;
use CRUD\Update;

class User
{
    private $create;
    private $read;
    private $update;
    private $notify;

    public function __construct()
    {
        $this->create = new Create;
        $this->read = new Read;
        $this->update = new Update;
    }

    public function addUser($user_name, $user_email, $user_password, $user_phone)
    {

        $user_code = rand(10000, 99999);

        $user = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_password' => $user_password,
            'user_phone' => $user_phone,
            'user_code' => $user_code,
        ];

        $this->create->create('users', $user);

        if (!$this->create->getResult()) {
            return false;
        } else {
            return true;
        }
    }

    public function validateCode($user_email, $user_code)
    {
        $this->read->read('users', "WHERE user_email = :email", "email={$user_email}");

        if (!$this->read->getResult()) {
            return false;
        } else {

            if ($this->read->getResult()[0]['user_code'] != $user_code) {
                return false;
            } else {
                $this->update->update('users', ['user_status' => 1], "WHERE user_email = :email", "email={$user_email}");
                return true;
            }

        }
    }
}