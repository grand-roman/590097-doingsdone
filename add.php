<?php

require_once("functions.php");
require_once("data.php");




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $task = $_POST;


  $res = setTasks($user_id);

  if ($res) {
    header("Location: /");
  }
  else {
        print("Ошибка запроса: " . mysqli_error($link));
  }
  
}

$add_content = include_template('add.php', [
  "project_tasks" => $projects,
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