<?php

require_once("functions.php");
require_once("data.php");
require_once("mysqli_helper.php");

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
} else {

    mysqli_set_charset($connect, "utf8");

    //SQL-запрос для получения списка проектов у текущего пользователя
    $sql = "SELECT id, name_project FROM Project  WHERE user_id = " $user_id ;
    $stmt = db_get_prepare_stmt($link, $sql, [$data]);
    $result = mysqli_query($connect, $stmt);
    if (!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    }
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //SQL-запрос для получения списка из всех задач у текущего пользователя
    $sql =  "SELECT name_task, file_task, done_at, deadline, status, project_id
            FROM Task  where project_id =" . $user_id;
    $stmt = db_get_prepare_stmt($link, $sql, [$data]);
    $result = mysqli_query($connect, $stmt);
    if (!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    }
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}



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