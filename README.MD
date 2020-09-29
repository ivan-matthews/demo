* **Ubuntu 18**.04.4 LTS;
* **PHP 7.1**.33-16+ubuntu16.04.1+deb.sury.org+1;
* **MySQL 5.7**.30-0ubuntu0.18.04.1
* **Apache/2.4**.29 (Ubuntu)

		git clone -b minimal_core https://github.com/ivan-matthews/demo.git ./

	для быстрой установки
	---
	
	в директории, где расположен файл ``cli``, выполнить в консоле
	
		php cli engine install false true
		
	или: с вставкой демо-данных:
		
		php cli engine install true true 4096MB
	или вручную:	
	---

    
1.		composer update


2. ***Конфиги в [52 коммите](https://github.com/ivan-matthews/demo/commit/0716284f4e99368fa18d2e9f8760b054114aaae6 "0716284f4e99368fa18d2e9f8760b054114aaae6")***

	Там главное в ``system/config/database.php`` соединение установить
	и в ``system/config/core.php`` хост свой прописать

	(Пока что доступен только **MySQL**)

3. ***В директории с файлом `cli` выполнить консольные команды*** 

	*		php cli migration run
	*		php cli migration insert

	если появиться ошибка, что БД не существует,

	* 		php cli migration make_db

4. ***Крон тоже работает***

	для автоматического запуска - добавить в список задач CRON строку

	* 		/PATH/TO/SITE/DIRECTORY/cli cron run

	запуск отдельных задач (если изестны ***IDs*** КРОН-задач): 
	* 		/PATH/TO/SITE/DIRECTORY/cli cron run [id_1] [id_2] [id_3] [...id]
	где ***IDs*** - `ct_id` записей в таблице `cron_tasks`, разделенных пробелом

	Если на сервере не доступен планировщик CRON, то можно выполнить POST или GET запрос
	удаленно на адрес
	*		http://mysite.com/cron.php
	с параметрами 
	* `key=[validation_key]` - ключ `validation_key` из файла *system/config/cron.php*
	* `token=[validation_token_key]` -  ключ `validation_token_key` из файла *system/config/cron.php*
	* `list[]` - список IDs CRON-задач

5. ***Демо админа***

	* логин: `admin@m.c`
	* пароль: `Qwerty12345^`
	* рабочий пример: [ссылка на рабочий пример](https://i-matthews.000webhostapp.com)
	
6. ```ALTER TABLE``` не применялась; миграцию делаем с чистой установки

7.	
		php cli server run
		
	для запуска локального сервера
