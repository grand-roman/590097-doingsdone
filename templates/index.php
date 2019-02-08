
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
                        <?php if (isset($task["Done"]) && $task["Done"] === false ): ?>
                            <tr 
                                <?php 
                                if (Task_Important($task) === true): ?> class="tasks__item task task--important"
                                <?    else: ?> class="tasks__item task"
                                <?php endif; ?>>
                                <td class="task__select">
                                    <label class="checkbox task__checkbox">
                                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                        <span class="checkbox__text"><?php if (isset($task["Task"])): ?> <?= strip_tags($task["Task"]);  ?> <?php endif; ?></span>
                                    </label>
                                </td>

                                <td class="task__file">
                                    <a class="download-link" href="#">Home.psd</a>
                                </td>

                                <td class="task__date"><?php if (isset($task["Execution date"])): ?> <?= strip_tags($task["Execution date"]);  ?> <?php endif; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($show_complete_tasks === 1 && isset($task["Done"]) && $task["Done"] === true): ?>
                                <tr class="tasks__item task task--completed">
                                    <td class="task__select">
                                        <label class="checkbox task__checkbox">
                                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                                            <span class="checkbox__text"><?php if (isset($task["Task"])): ?> <?= strip_tags($task["Task"]);  ?> <?php endif; ?></span>
                                        </label>
                                    </td>
                                    <td class="task__date"><?php if (isset($task["Execution date"])): ?> <?= strip_tags($task["Execution date"]);  ?> <?php endif; ?></td>

                                    <td class="task__controls">
                                    </td>
                                </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>