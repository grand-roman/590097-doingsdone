<?php

require_once("functions.php");
require_once("init.php");

if (!empty($_SESSION)) {

require_once("data.php");

if(isset($_GET['show_completed']) && $_GET['show_completed']) {
    $show_complete_tasks = 1;
} else {
    $show_complete_tasks = 0;
}

if(isset($_GET['task_id']) && isset($_GET['check'])) {
    $task_id = intval($_GET['task_id']);
    $res = getCompleted($task_id);
    if ($res) {
        header("Location: /index.php");
    }
}

if(isset($_GET['time'])) {
    $tasks=getTime($user_id, $project_id, $_GET['time']);
}

if($project_id === 0 || count($tasks) === 0) {
	$page_content = "<p>Ничего не найдено</p>";
	http_response_code(404);
}
else {

$page_content = include_template("index.php", [
    "tasks_with_information" => $tasks,
    "show_complete_tasks" => $show_complete_tasks
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