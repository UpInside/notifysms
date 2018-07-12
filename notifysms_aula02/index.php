<?php
/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 11/07/2018
 * Time: 15:37
 */

require_once __DIR__ . '/config.php';

?><!DOCTYPE>
<html lang="pt_br">
<head>
    <title>Cadastro de novo usuário!</title>
    <link rel="stylesheet" href="_cdn/css/reset.css">
    <link rel="stylesheet" href="_cdn/css/style.css">
</head>
<body>

<div class="container">

    <p class="container_subject">Insira seus dados abaixo para efetuar seu cadastro:</p>

    <form method="post" name="add_user">
        <input type="text" name="user_name" placeholder="Nome:">
        <input type="email" name="user_email" placeholder="E-mail:">
        <input type="password" name="user_password" placeholder="Senha:">
        <input type="text" name="user_phone" placeholder="Celular:">
        <button type="submit">Efetuar Cadastro</button>
    </form>

</div>

<div class="validate_code" style="display: none;"></div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="_cdn/js/script.js"></script>
</body>
</html>