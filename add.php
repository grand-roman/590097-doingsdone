<?php

require_once("functions.php");
require_once("data.php");


$errors_task = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$required_fields = ['name_task', 'project_tasks'];

  $task = $_POST;

   if (empty($task['name'])) {
        $errors_task['name'] = 'Обязательно заполните это поле';
    }


    if (strtotime($task['date']) <= strtotime("now")) {
        $errors_task['date'] = "Дата должна быть больше текущей";
    }
    if (!($task['date'])) {
        unset($errors_task['date']);
    }

     if (is_uploaded_file($_FILES['preview']['tmp_name'])) {
        $file_task = $_FILES['preview']['name'];
        $file_path = $_FILES['preview']['tmp_name'];
        move_uploaded_file($file_path, __DIR__ . '/' . $file_task);
        $task['file_task'] = $file_task;
    } else {
        $task['file_task'] = "";
    }


if (empty($errors_task)) {
  $res = setTasks($user_id, $task);
}
  if ($res) {
    header("Location: /");
  }
  else {
        print("Ошибка запроса: " . mysqli_error($link));
  }
  
}

$add_content = include_template('add.php', [
  "project_tasks" => $projects,
  "errors_task" => $errors_task,
  "task" => $task
]);

$add_layout_content = include_template('layout.php', [
    "project_tasks" => $projects,
    "tasks_with_information" => $tasks,
    "content" => $add_content,
    "title" => "Дела в порядке",
    "tasks_all" => $taskall
]);
print($add_layout_content);
?>