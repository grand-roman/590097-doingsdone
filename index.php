<?php

require_once("functions.php");
require_once("data.php");


if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$user_id = 1;

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

$projects = getProjects ($user_id);

if($project_id === 0){
    echo 404;
    exit;
}

$tasks = getTasks($user_id, $project_id); 

if(count($tasks)===0){
    echo 404;
    exit;
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