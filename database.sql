CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

CREATE TABLE IF NOT EXISTS Products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Products (id, name, category, price, stock, created_at) VALUES
(1, 'Laptop', 'Electronics', 100.00, 50, '2026-01-19 19:48:47'),
(3, 'Smartphone', 'Electronics', 850.00, 20, '2026-01-20 17:18:55'),
(4, 'Keyboard', 'Accessories', 25.99, 50, '2026-01-20 17:18:55'),
(5, 'Mouse', 'Accessories', 15.49, 80, '2026-01-20 17:18:55'),
(6, 'Office Chair', 'Furniture', 180.00, 10, '2026-01-20 17:18:55'),
(7, 'Desk Lamp', 'Furniture', 35.75, 25, '2026-01-20 17:18:55'),
(8, 'Monitor', 'Electronics', 299.99, 18, '2026-01-20 17:18:55'),
(9, 'Headphones', 'Accessories', 59.99, 40, '2026-01-20 17:18:55'),
(11, 'Notebook', 'Stationery', 3.50, 200, '2026-01-20 17:18:55'),
(12, 'Printer', 'Electronics', 120.00, 9, '2026-01-20 17:24:13');


CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
