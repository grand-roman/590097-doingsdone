<?php

require_once("functions.php");
require_once("init.php");


session_start();
$user_id = ($_SESSION['user']['id'] ?? NULL);

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

$projects = getProjects ($user_id);

if($project_id === 0){
    echo 404;
    exit;
}

$tasks = getTasks($user_id, $project_id); 

$taskall = getAllTasks($user_id); 

if(count($tasks)===0){
    echo 404;
    exit;
}

?>
