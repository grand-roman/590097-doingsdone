<?php

require_once("functions.php");
require_once("data.php");


if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$user_id = 1;

$project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : null;

//$connect = mysqli_connect("localhost", "root", "", "doingsdone");
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);



if ($connect === false) {
    http_response_code(503);
    $error = mysqli_error($connect);
    print("Ошибка MySQL:" .$error);
    exit();
} 

mysqli_set_charset($connect, "utf8");

//SQL-запрос для получения списка проектов у текущего пользователя
$sql = "SELECT * FROM Project WHERE user_id = ?";
$projects = request($connect, $sql, [$user_id]);

// Если параметр запроса отсутствует, либо если по этому id не нашли ни одной записи, 
// то вместо содержимого страницы возвращать код ответа 404
if (!array_search($project_id, array_column($projects, 'id')) && isset($_GET['project_id'])) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    };

    //SQL-запрос для получения списка из всех задач у текущего пользователя
$sql =  "SELECT * FROM Task WHERE user_id = ?";
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