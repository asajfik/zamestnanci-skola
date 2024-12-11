CREATE DATABASE company_management;

USE company_management;

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    isAdmin BOOLEAN DEFAULT FALSE
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
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
    positions (name, isAdmin)
VALUES ('CEO', TRUE);