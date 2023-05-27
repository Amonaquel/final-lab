## Rest API Example in PHP
A simple ToDo API in PHP.

## Requirements
- PHP 7+
- MySQL/MariaDB database server

## Usage
1. Create a MySQL database, a table, and populate it with data:

    ```sql
    CREATE DATABASE todo_db;
    USE todo_db;
    CREATE TABLE tasks(
        id MEDIUMINT NOT NULL AUTO_INCREMENT, 
        task VARCHAR(255) NOT NULL, 
        date_added DATETIME NOT NULL,
        done BOOLEAN NOT NULL DEFAULT false,
        PRIMARY KEY (id)
        );
    INSERT INTO tasks(task, date_added) VALUES ('Workout', NOW());
    INSERT INTO tasks(task, date_added) VALUES ('Water the plants', NOW());
    INSERT INTO tasks(task, date_added) VALUES ('Call Mom', NOW());
    ```
2. Set the MySQL credentials up by setting environment variables. You should never store sensitive database credentials in your source code. Instead, declare the following environment variables:

    ```shell
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=todo_db
    DB_USERNAME=root
    DB_PASSWORD=changeme
    ```
3. Run the API server:
    ```shell
    php -S localhost:3000
    ```
4. Send an HTTP request to the API endpoints listed below

### API endpoints

1. `/create` Create a new ToDo item

2. `/read.php` Get all todos

3. `/update` Update a ToDo item by its id

4. `/delete` Delete a ToDo item by its id

### License
MIT