
 <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox"<?php if ($show_complete_tasks === 1): ?> checked<?php endif; ?>>
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach($tasks_with_information as $task): ?>
                        <?php if (isset($task["status"]) && $task["status"] === false ): ?>
                            <tr 
                                <tr class="tasks__item task<?= Task_Important($task) ? " task--important" : '';?>">
                                <td class="task__select">
                                    <label class="checkbox task__checkbox">
                                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                        <span class="checkbox__text"><?php if (isset($task["name_task"])): ?> <?= strip_tags($task["name_task"]);  ?> <?php endif; ?></span>
                                    </label>
                                </td>

                                <td class="task__file">
                                    <a class="download-link" href="#"><?php if (isset($task["file_task"])): ?> <?= strip_tags($task["file_task"]);  ?> <?php endif; ?></a>
                                </td>

                                <td class="task__date"><?php if (isset($task["deadline"])): ?> <?= strip_tags($task["deadline"]);  ?> <?php endif; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($show_complete_tasks === 1 && isset($task["status"]) && $task["status"] === true): ?>
                                <tr class="tasks__item task task--completed">
                                    <td class="task__select">
                                        <label class="checkbox task__checkbox">
                                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
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