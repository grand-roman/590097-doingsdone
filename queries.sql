USE doingsdone;

INSERT INTO User (name_user, email, password, reg_date)
VALUES
('Гилфойл', 'chief_architect@piedpiper.com', md5('qwerty'), NOW()), -- 1
('Динеш', 'senior@piedpiper.com', md5('qwerty'), NOW()); -- 2

INSERT INTO Project (name_project, user_id)
VALUES
('Входящие', 1), -- 1
('Учеба',    2), -- 2
('Работа',   1), -- 3
('Домашние дела', 2), -- 4
('Авто',     2); -- 5

INSERT INTO Task (name_task, deadline, file_task, project_id, user_id, status)
VALUES
('Собеседование в IT компании', '2019-12-01', 'Home.psd', 3, 1, 0), -- 1
('Выполнить тестовое задание', '2018-12-25', 'Home.psd', 3, 1, 0), -- 2
('Сделать задание первого раздела', '2019-12-21',  'Home.psd', 2, 2, 1), -- 3
('Встреча с другом', '2018-12-22', 'Home.psd', 1, 1, 0), -- 4
('Купить корм для кота', '2019-02-09', 'Home.psd', 4, 2, 0), -- 5
('Заказать пиццу', '2019-02-10', 'Home.psd', 4, 2, 0); -- 6

-- получить список из всех проектов для одного пользователя
SELECT id, name_project
  FROM Project
 WHERE user_id = 1;

-- получить список из всех задач для одного проекта
SELECT * FROM Task WHERE user_id = 1;

-- пометить задачу как выполненную
UPDATE Task SET status = 1
WHERE id = 3;

-- обновить название задачи по её идентификатору
UPDATE Task SET name_task = 'Купить корм для зайца'
WHERE id = 5;
