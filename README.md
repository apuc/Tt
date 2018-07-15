###Тестовое задание

####Установка проекта:

- Запуск Docker из директории проекта
```sh
$ docker-compose up
```
- Инициализация проекта 
```sh
$ docker-compose exec php-cli ./init
```
- Настройка подключения к бд - *common/main-local.php*
```sh
'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=app',
            'username' => 'root',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
```
- Выполнение миграций
```sh
$ docker-compose exec php-cli ./yii migrate
```
- Заполнение базы тестовыми данными
```sh
$ docker-compose exec php-cli ./yii seed
```