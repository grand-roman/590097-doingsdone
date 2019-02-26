<?php

require_once("functions.php");
require_once("data.php");
require_once("init.php");

if (!empty($_SESSION)) {
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
} else {
	$layout_content = include_template('guest.php', [
        'title' => 'Дела в порядке']);
}
print($layout_content);
?>