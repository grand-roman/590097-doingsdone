<?php
require_once("functions.php");

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

$projects = getProjects ($user_id);

$filter =  isset($_GET['filter']) ? $_GET['filter'] : '';

$tasks = getTasks($user_id, $project_id, $filter);

$taskall = getAllTasks($user_id); 

$user = getUser($user_id);

?>