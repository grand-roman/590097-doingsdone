<?php
require_once("mysql_helper.php");

function include_template($name, $data) {
    $name = "templates/" . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

// случайное число для показа выполненных задач
$show_complete_tasks = rand(0, 1);

/**
 * Подсчитывает число задач для заданного проекта
 *
 * @param array $task_with_information
 * @param string $project_task
 *
 * @return int
 */
function Counting_Task ($task_with_information, $project_task ) {

    $count = 0;
    foreach ($task_with_information as $task) {
        if (isset($task["project_id"]) && $project_task === $task["project_id"]) {
            $count++;
        }
    }
    return $count;
}

/**
 * Возвращает true если до даты выполнения осталось меньше 24 часов или задача остлось не решенной 
 *
 * @param array $task
 *
 * @return boolean
 */
function Task_Important ($task){

    if (isset($task["status"]) && (((strtotime($task["deadline"])-time())<=86400) || (time()>=strtotime($task["deadline"]))))
    {
        return true;
    }
}

function request ($link, $sql, $data = []) {
 $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    if ($result = mysqli_stmt_get_result($stmt)) {
         $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $res;
        
    }
    else {
        http_response_code(503);
        $error = mysqli_error($link);
        print("Ошибка MySQL:" .$error);
        exit();
    }
}


class DbConnectionProvider
{
    protected static $connection;

    public static function getConnection()
    {
         if (self::connection === null) {
              self::connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
         }

         return self::connection;
    }
}

function getProjects ($userId){

    $sql = "SELECT id, name_project FROM Project WHERE user_id = ?";
    //$connection = DbConnectionProvider::getConnection();
    $projects = request($connection, $sql, [$user_id]);

    return $projects;
}

function getTasks($userId, $projectId){

    $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
            FROM Task WHERE user_id = ?";
    //$connection = DbConnectionProvider::getConnection();
    $tasks = request($connection, $sql, [$user_id]);

    return $tasks;
}
?>