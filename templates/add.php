        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="" method="post" enctype="multipart/form-data">
          <div class="form__row">
            <?php $task = isset($task['name_task']) ? $task['name_task'] : ""; ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="<?=$task;?>" placeholder="Введите название">
          </div>


          <div class="form__row">
            <label class="form__label" for="project">Проект</label>

            <select class="form__input form__input--select" name="project" id="project">
               <?php foreach ($project_tasks as $project): ?>
              <option value="<?=$project["id"] ?>"><?=$project["name_project"] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form__row">
                  <?php $data = isset($task['date']) ? $task['date'] : ""; ?>
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="date" name="date" id="date" value="<?=$data;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">

          </div>

          <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="preview" id="preview" value="">

              <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
              </label>
            </div>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>    