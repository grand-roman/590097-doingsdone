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
        if (isset($task["Category"]) && $project_task === $task["Category"]) {
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

    if (isset($task["Done"]) && (((strtotime($task["Execution date"])-time())<=86400) || (time()>=strtotime($task["Execution date"]))))
    {
        return true;
    }
}

function request ($link, $sql, $data = []) {
 $stmt = db_get_prepare_stmt($link, $sql, $user_id);
    $result = mysqli_query($connect, $stmt);
    if (!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    }
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $res;
}
?>