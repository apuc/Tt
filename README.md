### Тестовое задание

#### Установка проекта:

- Запуск Docker из директории проекта
```sh
$ docker-compose up --build -d
```
- Установка зависимостей
```sh
$ composer install
```
- Инициализация проекта 
```sh
$ docker-compose exec php-cli php init
```
- Настройка подключения к бд - *common/main-local.php*
```sh
'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=app',
            'username' => 'user',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
```
- Выполнение миграций
```sh
$ docker-compose exec php-cli php yii migrate
```
- Заполнение базы тестовыми данными
```sh
$ docker-compose exec php-cli php yii seed
```