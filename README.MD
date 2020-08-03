Конфиги в последнем коммите (с этим - в предпоследнем).

Там главное в ``system/config/database.php`` соединение установить
и в ``system/config/core.php`` хост свой прописать

(Пока что доступен только **MySQL**)

В директории с файлом `cli` выполнить в консоле команду 

```php cli migration run```

```php cli migration insert```

если появиться ошибка, что БД не существует,

```php cli migration makeDB```

Крон тоже работает

ручной запуск:
```php cli cron run [id]``` - где id (не обязательный парам) - `ct_id` записи в таблице `cron_tasks`

для автоматического - добавить в задачи CRON строку

```/PATH/TO/SITE/ROOT_DIRECTORY/cli cron run```

Демо админа:

логин: `admin@m.c`

пароль: `Qwerty12345^`

рабочий пример: http://f0455899.xsph.ru/