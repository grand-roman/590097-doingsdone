<?php

require_once("functions.php");

if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$user_id = 1;

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
