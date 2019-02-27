<?php
require_once("functions.php");

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

$projects = getProjects ($user_id);

$tasks = getTasks($user_id, $project_id); 

$taskall = getAllTasks($user_id); 

$user = getUser($user_id);

?>