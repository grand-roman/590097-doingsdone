<?php

require_once("functions.php");
require_once("data.php");

$page_content = include_template("index.php", [
    "tasks_with_information" => $tasks_with_information,
    "show_complete_tasks" => $show_complete_tasks
]);

$layout_content = include_template("layout.php", [
    "project_tasks" => $project_tasks,
    "tasks_with_information" => $tasks_with_information,
    "content" => $page_content,
    "title" => "Дела в порядке"
]);
print($layout_content);
?>