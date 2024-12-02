USE customers;

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department_id INT NOT NULL,
    position_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id),
    FOREIGN KEY (position_id) REFERENCES positions(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

INSERT INTO departments (name) VALUES ('Engineering'), ('Marketing'), ('Sales');
INSERT INTO positions (title) VALUES ('Software Engineer'), ('Marketing Manager'), ('Sales Manager');
INSERT INTO roles (name) VALUES ('admin'), ('user');
INSERT INTO employees (name, email, department_id, position_id, role_id) VALUES ('Boreček', 'asajfik@seznam.cz', 1, 1, 1);