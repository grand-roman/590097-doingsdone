<?php

require_once("functions.php");
require_once("data.php");


if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}


//$connect = mysqli_connect("localhost", "root", "", "doingsdone");
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

 $user_id = 1;

if ($connect === false) {
    $error = mysqli_error($connect);
    print("Ошибка MySQL:" .$error);
    exit();
} 

mysqli_set_charset($connect, "utf8");

//SQL-запрос для получения списка проектов у текущего пользователя
$sql = "SELECT id, name_project FROM Project  WHERE user_id = ?";
$projects = request($connect, $sql, [$user_id]);

    //SQL-запрос для получения списка из всех задач у текущего пользователя
$sql =  "SELECT name_task, file_task, done_at, deadline, status, project_id
        FROM Task  where project_id = ?";
$tasks = request($connect, $sql, [$user_id]);
   

$page_content = include_template("index.php", [
    "tasks_with_information" => $tasks,
    "show_complete_tasks" => $show_complete_tasks
]);

$layout_content = include_template("layout.php", [
    "project_tasks" => $projects,
    "tasks_with_information" => $tasks,
    "content" => $page_content,
    "title" => "Дела в порядке"
]);
print($layout_content);
?>