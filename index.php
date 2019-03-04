<?php

require_once("functions.php");
require_once("init.php");

if (!empty($_SESSION)) {

require_once("data.php");

$show_complete_tasks = isset($_GET['show_completed']) ? intval($_GET['show_completed']) : 0;


if(isset($_GET['task_id']) && isset($_GET['check'])) {
    $task_id = intval($_GET['task_id']);
    $result = getCompleted($task_id, $_GET['check']);
    header("Location: /index.php");
}

if($project_id === 0 || count($tasks) === 0) {
	$page_content = "<p>Ничего не найдено</p>";
	http_response_code(404);
}
else {

$page_content = include_template("index.php", [
    "tasks_with_information" => $tasks,
    "show_complete_tasks" => $show_complete_tasks,
    "filter" => $filter,
    "project_id" => $project_id
]);

}

$layout_content = include_template("layout.php", [
    "project_tasks" => $projects,
    "tasks_with_information" => $tasks,
    "content" => $page_content,
    "title" => "Дела в порядке",
    "tasks_all" => $taskall,
    'user_name' => $user[0]['name_user']
]);
}
 else {
	$layout_content = include_template('guest.php', [
        'title' => 'Дела в порядке']);
}
print($layout_content);

?>