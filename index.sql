CREATE DATABASE company_management;

USE company_management;

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'user') DEFAULT 'user'
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department_id INT NOT NULL,
    position_id INT NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    start_date DATE NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments (id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions (id) ON DELETE CASCADE
);

INSERT INTO
    departments (name)
VALUES ('Engineering'),
    ('Marketing'),
    ('HR');

INSERT INTO
    positions (name)
VALUES ('Software Engineer'),
    ('Marketing Manager'),
    ('HR Specialist');

INSERT INTO
    users (username, password, role)
VALUES (
        'admin',
        MD5('admin123'),
        'admin'
    ),
    (
        'manager',
        MD5('manager123'),
        'manager'
    );

INSERT INTO
    employees (
        name,
        email,
        department_id,
        position_id,
        salary,
        start_date
    )
VALUES (
        'Jan Novák',
        'jan.novak@example.com',
        1,
        1,
        60000,
        '2023-01-15'
    ),
    (
        'Marie Černá',
        'marie.cerna@example.com',
        2,
        2,
        45000,
        '2023-02-01'
    );