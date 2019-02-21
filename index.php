<?php

require_once("functions.php");
require_once("data.php");


$page_content = include_template("index.php", [
    "tasks_with_information" => $tasks,
    "show_complete_tasks" => $show_complete_tasks
]);

$layout_content = include_template("layout.php", [
    "project_tasks" => $projects,
    "tasks_with_information" => $tasks,
    "content" => $page_content,
    "title" => "Дела в порядке",
    "tasks_all" => $taskall
]);
print($layout_content);
?>