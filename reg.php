<?php

require_once("functions.php");
require_once("data.php");

$errors_user = [];

$reg_content = include_template('reg.php', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_reg = $_POST['signup'];
    $req_fields = ['email', 'password', 'name'];
    $email = checkEmail($user_reg['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors_user['email'] = "E-mail введён некорректно";
    }

    foreach ($req_fields as $required_field) {
        if (empty($user_reg[$required_field])) {
            $errors_user[$required_field] = 'Обязательно заполните это поле';
        }
    }

    if (!empty($user_reg['email'])){

    	$res = repeatEmail($email);
    }

    if (mysqli_num_rows($res) > 0) {
           $errors_user[] = 'Пользователь с этим email уже зарегистрирован';
        }

    if (!empty($user_reg['password'])) {
        $password = password_hash($user_reg['password'], PASSWORD_DEFAULT);
    }
   
    if (count($errors_user===0)) {
        regUser(
		    $user_reg['email'],
		    $user_reg['name'],
		    $password);
		header("Location: /");
       
    }
     else {
      $reg_content = include_template('reg.php', ['errors' => $errors_user, 'form' => $user_reg]);
    }
}
$reg_layout = include_template('reg-layout.php', [
    'content'    => $reg_content,
    'title'      => 'Регистрация'
]);
print($reg_layout);

?>