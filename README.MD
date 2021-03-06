* **Ubuntu 18**.04.4 LTS;
* **PHP 7.1**.33-16+ubuntu16.04.1+deb.sury.org+1;
* **MySQL 5.7**.30-0ubuntu0.18.04.1
* **Apache/2.4**.29 (Ubuntu)

	![Скриншот мусите](https://ivan-matthews.github.io/public/view/default/imgs/sreenshot.png "Скриншот к проекту")

		git clone https://github.com/ivan-matthews/demo.git ./

	для быстрой установки
	---
	
	в директории, где расположен файл ``cli``, выполнить в консоле
	
		php cli engine install
		
	или: с вставкой демо-данных:
		
		php cli engine install true 4096MB
		
	для запуска локального сервера
	
		php cli server run
	или вручную:	
	---

	Сначала переименовать файл ``composer.json.default`` в ``composer.json``.
	Файл ``.htaccess.default`` в ``.htaccess``
    
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

	Файл ``/system/migrations/inserts/2020_07_14_071756_insert_geo_cities_1594750676.php``
	будет импортировать в БД около 2 000 000 записей, по-этому процесс затянется,
	будут регулярные прерывания с ошибкой `memory limit`, так как при превышении 
	в * ** *256 Мб*, срабатыват метод **InsertGeoCities202007140717561594750676 -> lastHope()**.
	
	* *256 МБ* - будет дефолтным значением, если лимит не установлен (`ini_get('memory_limit')` показывает **-1**)
	* *256 Мб* можно повысить в **php.ini**, директива: `memory_limit` до пары ГБ, если памяти достаточно, или понизить до пары МБ, если 256 - много.

	Для возобновления миграции, еще раз выполнить команду
	*		php cli migration insert

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
