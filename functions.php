<?php
require_once("mysql_helper.php");
error_reporting(E_ALL);

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

/**
 * Создает массив на основе готового SQL запроса и переданных данных
 *
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return array результ SQL запроса
 */

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
         if (self::$connection === null) {
              self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if(!self::$connection) {

            http_response_code(503);
            print("Ошибка MySQL: connection failed");
            exit();
            }

            mysqli_set_charset(self::$connection, "utf8");
        }

         return self::$connection;
    }
}

//SQL-запрос для получения списка проектов у текущего пользователя
function getProjects ($user_id){

    $connection = DbConnectionProvider::getConnection();
    $sql = "SELECT id, name_project FROM Project WHERE user_id = ?";

    $parameters = [$user_id];

    return request($connection, $sql, $parameters);
}

//SQL-запрос для получения списка из всех задач у текущего пользователя
function getTasks($user_id, $project_id = null){

    $connection = DbConnectionProvider::getConnection();
    $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
            FROM Task WHERE user_id = ?";
    $parameters = [$user_id];

    if($project_id != null){
        $sql .= " AND project_id = ?";
        $parameters[]= $project_id;
    }

    return request($connection, $sql, $parameters);
}

function getAllTasks($user_id){

    $connection = DbConnectionProvider::getConnection();
     $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
            FROM Task WHERE user_id = ?";
    $parameters = [$user_id];

    return request($connection, $sql, $parameters);
}

function setTasks(int $user_id, string $name_task, int $project_id, ?string $date, ?string $file){

    $connection = DbConnectionProvider::getConnection();
    $sql = 'INSERT INTO Task SET user_id = ?, name_task = ?, creation_at = NOW()';
    $values = [$user_id, $name_task];

    if ($project_id !== 0) {
    $sql .= ', project_id = ?';
    $values[] = $project_id;
    }   else {
        $sql .= ', project_id = NULL';
    }



    if ($date !== null) {
    $sql .= ', deadline = ?';
    $values[] = $date;
    }

    if ($file !== null) {
    $sql .= ', file_task = ?';
    $values[] = $file;
    }

    $stmt = db_get_prepare_stmt($connection, $sql, $values);
    mysqli_stmt_execute($stmt);
}

function checkProject(int $user_id, string $project){

    $connection = DbConnectionProvider::getConnection();
    $sql = "SELECT name_project FROM Project WHERE name_project = '" . $project ."'AND user_id = ' " . $user_id . "' LIMIT 1";
    $res = mysqli_query($connection, $sql);

    return $res;
}

function setProject(int $user_id, string $project){

    $connection = DbConnectionProvider::getConnection();
    $sql = 'INSERT INTO Project SET user_id = ?, name_project = ?';
    $values = [$user_id, $project];

    $stmt = db_get_prepare_stmt($connection, $sql, $values);
    mysqli_stmt_execute($stmt);
}


function regUser($email,$name,$password){

    $connection = DbConnectionProvider::getConnection();
    $sql = 'INSERT INTO User SET email=?, name_user=?, password=?, reg_date=NOW()';
    $values = [$email,$name,$password];

    $stmt = db_get_prepare_stmt($connection, $sql, $values);
    mysqli_stmt_execute($stmt);
}

function repeatEmail($repeat_email){

    $connection = DbConnectionProvider::getConnection();
    $sql = "SELECT * FROM User WHERE email = ?";
    $parameters = [$repeat_email];

    return  request($connection, $sql, $parameters);
}

function logUser($email){

    $connection = DbConnectionProvider::getConnection();
    $sql = "SELECT * FROM User WHERE email = '". $email ."'";
    $res = mysqli_query($connection, $sql);
    $parameters = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : NULL;

    return $parameters;
}

function getUser($user_id){

    $connection = DbConnectionProvider::getConnection();
    $sql =  "SELECT *
            FROM User WHERE id = ?";
    $parameters = [$user_id];

    return request($connection, $sql, $parameters);

}

function getTime($user_id, $project_id = null, $time){

    $connection = DbConnectionProvider::getConnection();
    if($time == 'today') {

        $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
                FROM Task WHERE user_id = ? " . " AND DAY(deadline) = DAY(NOW())";
        $parameters = [$user_id];

        if($project_id != null){
            $sql .= " AND project_id = ?";
            $parameters[]= $project_id;
        }
        $res = request($connection, $sql, $parameters);
    }
    else if ($time == 'tomorrow') {
        $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
                FROM Task WHERE user_id = ? " . " AND DAY(deadline) = DAY(DATE_ADD(NOW(), INTERVAL 1 DAY))";
        $parameters = [$user_id];

        if($project_id != null){
            $sql .= " AND project_id = ?";
            $parameters[]= $project_id;
        }
        $res = request($connection, $sql, $parameters);
    }

    else if ($time == 'overdue') {
        $sql =  "SELECT name_task, file_task, deadline, status, user_id, project_id
                FROM Task WHERE user_id = ? " . " AND deadline < NOW() ORDER BY deadline ASC";
        $parameters = [$user_id];

        if($project_id != null){
            $sql .= " AND project_id = ?";
            $parameters[]= $project_id;
        }
        $res = request($connection, $sql, $parameters);
    }

    return $res;
}

function getCompleted($task_id){

    $connection = DbConnectionProvider::getConnection();
    $sql = "SELECT * FROM Task WHERE id = ?";
    $parameters = [$task_id];
    $res = request($connection, $sql, $parameters);

    if($res[0]['status']) {
        $sql = "UPDATE Task SET status = 0 WHERE id = ?";
         $parameters = [$task_id];

    } else if (!$tasks[0]['status']) {
        $sql = "UPDATE Task SET status = 1 WHERE id = ?";
        $parameters = [$task_id];
    }

    $task = request($connection, $sql, $parameters);

    return $task;

}
?>