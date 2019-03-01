
 <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item <?=(!isset($_GET['time']) ? "tasks-switch__item--active" : "");?> ">Все задачи</a>
                        <a href="/index.php?time=today" class="tasks-switch__item <?=(isset($_GET['time']) && $_GET['time'] == "today" ? "tasks-switch__item--active" : "");?>">Повестка дня</a>
                        <a href="/index.php?time=tomorrow" class="tasks-switch__item <?=(isset($_GET['time']) && $_GET['time'] == "tomorrow" ? "tasks-switch__item--active" : "");?>">Завтра</a>
                        <a href="/index.php?time=overdue" class="tasks-switch__item <?=(isset($_GET['time']) && $_GET['time'] == "overdue" ? "tasks-switch__item--active" : "");?>">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox"<?php if ($show_complete_tasks === 1): ?> checked<?php endif; ?>>
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach($tasks_with_information as $task): ?>
                        <?php if (isset($task["status"]) && $task["status"] === 0 ): ?>
                            <tr 
                                <tr class="tasks__item task<?= Task_Important($task) ? " task--important" : '';?>">
                                <td class="task__select">
                                    <label class="checkbox task__checkbox">
                                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$task['id'];?>">
                                        <span class="checkbox__text"><?php if (isset($task["name_task"])): ?> <?= strip_tags($task["name_task"]);  ?> <?php endif; ?></span>
                                    </label>
                                </td>

                                <td class="task__file">
                                    <?php if (isset($task["file_task"])): ?>
                                        <a class="download-link" href="<?=$task["file_task"];?>" target="_blank"> 
                                            <?= strip_tags($task["file_task"]);  ?> <?php endif; ?></a>
                                </td>

                                <td class="task__date"><?php if (isset($task["deadline"])): ?> <?= strip_tags($task["deadline"]);  ?> <?php endif; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($show_complete_tasks === 1 && isset($task["status"]) && $task["status"] === 1): ?>
                                <tr class="tasks__item task task--completed">
                                    <td class="task__select">
                                        <label class="checkbox task__checkbox">
                                            <input class="checkbox__input visually-hidden" type="checkbox" value="<?=$task['id'];?>">
                                            <span class="checkbox__text"><?php if (isset($task["name_task"])): ?> <?= strip_tags($task["name_task"]);  ?> <?php endif; ?></span>
                                        </label>
                                    </td>
                                    <td class="task__date"><?php if (isset($task["deadline"])): ?> <?= strip_tags($task["deadline"]);  ?> <?php endif; ?></td>

                                    <td class="task__controls">
                                    </td>
                                </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>