
 <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                                <a href="/index.php?filter=all" class="tasks-switch__item
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'all'): ?>
                                        tasks-switch__item--active
                                    <?php endif; ?>">Все задачи</a>
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'all' && isset($_SESSION['user'])): ?>
                                        <?php $tasks = buildTimeFilterUrl($_SESSION['user']['id'], $_SESSION['project_id'], $_GET['filter']);?>
                                    <?php endif; ?>

                                <a href="/index.php?filter=today" class="tasks-switch__item
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'today'): ?>
                                        tasks-switch__item--active
                                    <?php endif; ?>">Повестка дня</a>
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'today' && isset($_SESSION['user'])): ?>
                                        <?php $tasks = buildTimeFilterUrl($_SESSION['user']['id'], $_SESSION['project_id'], $_GET['filter']);?>
                                    <?php endif; ?>

                                <a href="/index.php?filter=tomorrow" class="tasks-switch__item
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'tomorrow'): ?>
                                        tasks-switch__item--active
                                    <?php endif; ?>">Завтра</a>
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'tomorrow' && isset($_SESSION['user'])): ?>
                                        <?php $tasks = buildTimeFilterUrl($_SESSION['user']['id'], $_SESSION['project_id'], $_GET['filter']);?>
                                    <?php endif; ?>

                                <a href="/index.php?filter=overdue" class="tasks-switch__item
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'overdue'): ?>
                                        tasks-switch__item--active
                                    <?php endif; ?>">Просроченные</a>
                                    <?php if (isset($_GET['filter']) && $_GET['filter'] === 'overdue' && isset($_SESSION['user'])): ?>
                                        <?php $tasks = buildTimeFilterUrl($_SESSION['user']['id'], $_SESSION['project_id'], $_GET['filter']);?>
                                    <?php endif; ?>
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