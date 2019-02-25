<?php

require_once("functions.php");

$errors_user = [];

$reg_content = include_template('reg.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_reg = $_POST['signup'];
    $req_fields = ['email', 'password', 'name'];

    foreach ($req_fields as $required_field) {
        if (empty($user_reg[$required_field])) {
            $errors_user[$required_field] = 'Обязательно заполните это поле';
        }
    }

    if (!empty($user_reg['password'])) {
        $password = password_hash($user_reg['password'], PASSWORD_DEFAULT);
    }
   
    if (count($error===0)) {
        vrem(
		    $user_reg['email'],
		    $user_reg['name'],
		    $password);
		header("Location: /");
       
    }
}
$reg_layout = include_template('reg-layout.php', [
    'content'    => $reg_content,
    'title'      => 'Регистрация'
]);
print($reg_layout);


?>