# DBBuilder
Создавайте таблицы в базе данных с помощью элегантного php кода.

## Настройка
В файле settings/database.php укажите параметры подключения к базе данных, DBBuilder работает только с базой данных MYSQL

## Введение
Выполнять команды нужно через файл DBBuilder.

### Миграции
***
Миграция - в данном контексте это класс, с помощью которого будет конфигурироваться или очищаться таблица. Чтобы создать файл миграции, нужно выполнить команду

```php DBBuilder make:migration migration_name```

В конец имени миграции будет добавлено 'Migration'

В папке 'Migrations' появится файл миграции с базовой структурой. В данном классе описанны 2 метода.

### Метод 'up' служит для конфигурации вашей таблицы.

Чтобы создать таблицу в базе данных нужно вызвать метод 'create' свойства-объекта 'DBBuilder' вашего класса миграции. 

```php
$this->DBBuilder->create(string table_name, array fields)
```

В списке fields вы можете создавать поля, DBBuilder автоматически создал поле 'id'.
Поля создаются с помощью свойства-объекта "table" вашего класса миграции. Методы этого объекта создают поля определённого типа, либо уже готовые, например 'increment'.

Все методы 'table'

- string(name, length) - поле типа VARCHAR
- integer(name, length) - поле типа INT
- boolean(name, length) - поле типа BOOLEAN
- text(name, length) - поле типа TEXT

Пример создания поля:
```php
$this->table->string('name', 70)
```
Этот код вернёт объект класса Field, у которого есть методы для конфигурирования поля

- nullable() - добавит 'NULL' для поля, по умолчанию поле имеет 'NOT NULL'
- default(value) - добавит значение по умолчанию для поля
- autoIncrement() - добавит AUTO_INCREMENT для поля
- index() - добавит индекс INDEX для поля
- unique() - добавит индекс UNIQUE для поля
- primaryKey() - добавит индекс PRIMARY_KEY для поля
- fullText() - добавит индекс FULLTEXT для поля
- spatial() - добавит индекс SPATIAL для поля

Пример создания поля:
```php
$this->table->string('login', 70)->unique()
```
***

### Метод 'drop' служит для полной очистки таблицы

Для этого надо передать имя таблицы в метод 'drop' свойства-объекта 'DBBuilder'

```php
$this->DBBuider->drop('users');
```
***

#### Пример создания таблицы 'users':

```php
<?php
use Core\Components\Migrations\Migration;

class CreateUserTableMigration extends Migration
{
	public function up()
	{
		$this->DBBuilder->create('users', [
			$this->table->increment('id'),
			$this->table->string('login', 50)->unique(),
			$this->table->string('password', 50),
			$this->table->boolean('is_admin')->default(0),
			$this->table->text('about')->nullable()
		]);
	}

	public function drop()
	{
		$this->DBBuilder->drop('users');
	}
}

```

***

### Выполнение миграций

Чтобы выполнить миграции надо выполнить команду
```
php DBBuilder migrate
```
Если перед этим нужно очистить таблицы, установите флаг --refresh
```
php DBBuilder migrate --refresh
```
Если нужно выполнить выборочные миграции, просто укажите названия классов-миграций, которые нужно выполнить
```
php DBBuilder migrate className1 className2
```
В этом случае также можно установить флаг --refresh
```
php DBBuilder migrate className1 className2 --refresh
```

## Полный цикл создания таблицы 'articles' в базе данных
Зайдём в файл 'settings/database.php' и укажем параметры подключения к базе данных
```php
<?php

// Параметры подключения к базе данных
const DB = [
	'host' => 'localhost',
	'login' => 'root',
	'password' => '',
	'db_name' => 'test'
];

```
После создадим файл миграции
```
php DBBuilder make:migration CreateArticleTable
```
Дальше создадим поля для таблицы
```php
<?php
use Core\Components\Migrations\Migration;

class CreateArticleTableMigration extends Migration
{
	public function up()
	{
		$this->DBBuilder->create('articles', [
			$this->table->increment('id'),
			$this->table->string('slug', 70)->unique(),
			$this->table->string('title', 70)->unique(),
			$this->table->text('body')
		]);
	}

	public function drop()
	{
		$this->DBBuilder->drop('articles');
	}
}

```
Выполним данную миграцию
```
php DBBuilder migrate CreateArticleTableMigration
```
