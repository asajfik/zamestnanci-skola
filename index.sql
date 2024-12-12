CREATE DATABASE company_management;

USE company_management;

DROP TABLE positions;

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
    password VARCHAR(255),
    department_id INT NOT NULL,
    position_id INT NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    start_date DATE NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments (id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions (id) ON DELETE CASCADE
);

CREATE TABLE registration_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES employees (id) ON DELETE CASCADE
);

INSERT INTO
    departments (name)
VALUES ('Engineering'),
    ('Marketing'),
    ('HR'),
    ('Management');

INSERT INTO
    positions (name)
VALUES ('Software Engineer'),
    ('Marketing Manager'),
    ('HR Specialist');

INSERT INTO positions (name, isAdmin) VALUES ('CEO', TRUE);

INSERT INTO
    employees (
        name,
        email,
        password,
        department_id,
        position_id,
        salary,
        start_date
    )
VALUES (
        'Adam Havlík',
        'asajfik@seznam.cz',
        '$2y$10$q8Dx8lDfZUUsPLjXINNt5uzaAUrmgNRPoq56p.UCx4xNTwn5QiX4C',
        4,
        4,
        60000.00,
        '2021-01-01'
    )