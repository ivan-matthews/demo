<?php

	return array(
		'default_description_string'=> 'описание команды отсутствует',
		'remove_cache'				=> 'удалить все кеш-файлы',
		'structure_info'			=> 'показать структурированную информацию',
		'create_migration_table'	=> 'создать таблицу миграций',
		'alter_migration_table'		=> 'изменить таблицу миграций',
		'run_migrations'			=> 'запустить миграцию',
		'make_new_controller'		=> 'создать новый контроллер (без доп. экшенов)',
		'make_standard_class'		=> 'создать новый стандартный класс',
		'run_cron_tasks_with_ids'	=> 'запустить CRON, со списком ID-задач (не обязательно)',
		'un_structure_info'			=> 'показать неструктурированную информацию',
		'test_interactive_shell'	=> 'тестировать интерактивную оболочку',
		'standard_class_file'		=> 'создать стандартный файл класса',
		'new_cli_command_class_file'=> 'создать файл класса новой CLI-команды',
		'new_controller_with_acts'	=> 'создать новый контроллер с доп. экшенами (через пробел)',
		'new_cron_task'				=> 'создать новую крон-задачу',
		'new_db_connection_class'	=> 'создать новый класс подключения базы данных',
		'new_insert_item_class'		=> 'создать класс записи данных в БД',
		'remove_database'			=> 'уничтожить базу данных',
		'insert_data_to_db'			=> 'залить данные миграций в базу данных',
		'make_new_database'			=> 'создать новую базу данных',
		'run_develop_server'		=> 'запустить сервер разработки',
		'test_description_string'	=> 'создать тест контроллер / экшн',
		'make_geo_data'				=> 'скачать, распаковать, распарсить, залить в БД (в разработке) GEO-данные',

		'sometime_went_wrong'		=> 'Что-то пошло не так... ',
		'command_not_found'			=> 'Команда "%CMD_ARR%" не найдена или вернула пустой результат! ',
		'help_center_has_called'	=> 'Была вызвана справка:',
		'file'						=> 'Файл: ',
		'folder'					=> 'Папка: ',
		'successful_removed'		=> ' успешно удален!',
		'cache_cleared'				=> 'Кеш очистен!',
		'cron_task'					=> 'КРОН-задача ',
		'skipped'					=> 'пропущена',
		'successful'				=> 'успешна',
		'by_file'					=> 'из-за блокировки!',
		'by_id'						=> 'ID задачи нету в списке!',
		'by_time'					=> 'по времени последнего выполнения!',
		'by_error'					=> 'из-за ошибки',
		'no_tasks_to_exec'			=> 'Нечего выполнять!',
		'successful_ended'			=> 'успешно выполена',
		'with_message'				=> ' с сообщением: ',
		'without_message'			=> ' без уведомлений!',
		'native_cmds_header'		=> 'Все команды:',
		'alias_cmds_header'			=> 'Синонимы команд:',
		'enter_please_desired_value'=> 'Введите пожалуйста "%DESIRED_VALUE%"',
		'database_dropped'			=> 'База Данных "%DATABASE%" успешно удалена!',
		'database_not_dropped'		=> 'База Данных "%DATABASE%" не была удалена!',
		'database_created'			=> 'База Данных "%DATABASE%" успешно создана!',
		'database_not_created'		=> 'База Данных "%DATABASE%" не была создана!',
		'insert'					=> 'Вставка данных ',
		'migration'					=> 'Миграция ',
		'error_header'				=> 'ОШИБКА!',
		'warning_header'			=> 'ВНИМАНИЕ!',
		'success_header'			=> 'УСПЕХ!',
		'class_not_created'			=> "Класс \"%CLASS_NAME%\" не был создан в\n\t%CLASS_FILE%!",
		'class_already_created'		=> "Класс \"%CLASS_NAME%\" был создан ранее в %CLASS_FILE%!",
		'class_success_created'		=> "Класс \"%CLASS_NAME%\" успешно создан в\n\t%CLASS_FILE%!",
		'command_success_save'		=> "Команда \"%CMD_NAME%\" успешно сохранена в %CMD_FILE%!",
		'command_not_save'			=> "Команда \"%CMD_NAME%\" не была сохранена в %CMD_FILE%!",
		'controller_success_created'=> '%TYPE% "%FILE%" успешно создано в %PATH%!',
		'controller_not_created'	=> '%TYPE% "%FILE%" уже существует в %PATH%!',
		'folder_making'				=> 'Папка "%FOLDER%" успешно создана!',
		'cron_task_making'			=> 'КРОН-задача "%CLASS_NAME%" успешно создана в %CLASS_FILE%',
		'cron_task_not_making'		=> 'КРОН-задача "%CLASS_NAME%" ранее создана создана в %CLASS_FILE%',
		'new_db_class_created'		=> 'Класс Базы Данных "%CLASS_NAME%" успешно создан в %FILE_NAME%',
		'new_db_class_not_created'	=> 'Класс Базы Данных "%CLASS_NAME%" не был создан в %FILE_NAME%',
		'session_file_has_removed'	=> "Сессионный файл \"%CLASS_NAME%\" был удален"/* из %FILE_NAME%*/,
		'session_file_not_removed'	=> "Сессионный файл \"%CLASS_NAME%\" не был удален"/* из %FILE_NAME%*/,
		'session_file_has_skipped'	=> "Сессионный файл \"%CLASS_NAME%\" был пропущен"/* из %FILE_NAME%*/,
		'develop_server_date'		=> "%DATE% в %TIME% (%TIMEZONE%): ",
		'develop_server_started'	=> "Сервер запущен!",
		'develop_server_details'	=> "Детали смотрите по адресу %ADDRESS%. ",
		'develop_server_down'		=> "Сервер упал!",
		'welcome_to_interactive_mode'=> 'Вы вошли в интерактивный режим консоли. ',
		'enter_please_cmd_to_exit'	=> 'Для выхода нажмите %COMMAND%...',
		'set_config_value_description'=> 'установить в конфиг новое значение или обновить старое',
		'install_value_description'=> 'начать процесс установки системы',
		'wait_composer_install'		=> 'Ожидаем... Обновляется композер...',
		'wait_composer_ready'		=> 'Готово!',

		'use_mysql'					=> 'Используем MySQL? Y/CTRL+C',
		'use_mysql_simple'			=> '',
		'enter_db_host'				=> 'Введите хост Базы Данных',
		'enter_db_host_simple'		=> ' (обычно LOCALHOST)',
		'enter_db_port'				=> 'Введите порт Базы Данных',
		'enter_db_port_simple'		=> ' (обычно 3306)',
		'enter_db_user'				=> 'Введите имя пользователя Базы Данных',
		'enter_db_user_simple'		=> ' (обычно ROOT)',
		'enter_db_base'				=> 'Введите имя Базы Данных',
		'enter_db_base_simple'		=> ' (если не существует - будет создана)',
		'enter_db_password'			=> 'Введите пароль пользователя Базы Данных',
		'enter_db_password_simple'	=> '',
		'enter_site_scheme'			=> 'Введите протокол сайта',
		'enter_site_scheme_simple'	=> ' (обычно HTTP или HTTPS)',
		'enter_site_host'			=> 'Введите хост сайта',
		'enter_site_host_simple'	=> ' (без протоколов HTTP или HTTPS)',
		'enter_site_name'			=> 'Введите имя сайта',
		'enter_site_name_simple'	=> ' (придумайте что-то оригинальное)',

		'new_config_is'			=> 'Новые параметры:',
		'new_config_parent_core'		=> 'Сайт:',
		'new_config_parent_database'	=> 'База Данных',

		'new_config_db_driver'		=> 'Драйвер БД:',
		'new_config_site_scheme'	=> 'Протокол сайта:',
		'new_config_site_host'		=> 'Хост сайта:',
		'new_config_site_name'		=> 'Имя сайта:',

		'new_config_host'	=> 'Хост Базы Данных:',
		'new_config_port'	=> 'Порт Базы Данных:',
		'new_config_user'	=> 'Пользователь БД:',
		'new_config_pass'	=> 'Пароль Базы Данных:',
		'new_config_base'	=> 'Имя Базы Данных:',
		'new_config_agree'	=> 'Применить эти установки? (Y/N)',
	);