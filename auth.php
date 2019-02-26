<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');
error_reporting(E_ALL);

$errors_log = [];
$user_log = [];

$auth_content = include_template('auth.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_log = $_POST;
    $req_fields = ['email', 'password'];

    foreach ($req_fields as $required_field) {
        if (empty($user_log[$required_field])) {
            $errors_log[$required_field] = 'Это поле надо заполнить';
        }
    }
    $user = logUser($user_log['email']);

    if (empty($errors_log) && $user) {
        if (password_verify($user_log['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors_log['password'] = 'Неверный пароль';
        }
    } else if (empty($errors_log) && !$user) {
        $errors_log['email'] = 'Такой пользователь не найден';
    }

    if (empty($errors_log)) {
        header("Location: /index.php");
        exit();
    } 
} 

$auth_content = include_template('auth.php', [
    'user_log' => $user_log,
    '$errors_log' => $errors_log 
]);


$layout_content = include_template('layout.php', [
    'content' => $auth_content,
    'tasks_with_information' => [],
    'tasks_all' => [],
    'project_tasks' => [],
    'user_name' => "",
    'title' => 'Дела в порядке | Вход'
]);
print($layout_content);

?>