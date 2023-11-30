-- Crear DB
CREATE DATABASE IF NOT EXISTS ecom1_project;

-- Usar DB
USE ecom1_project;

-- Crear la tabla role
CREATE TABLE IF NOT EXISTS role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

-- Insertar roles
INSERT INTO role (name) VALUES ('user'), ('admin');

-- Crear la tabla address
CREATE TABLE IF NOT EXISTS address (
    id INT PRIMARY KEY AUTO_INCREMENT,
    street VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100),
    country VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL
);

-- Crear la tabla user
CREATE TABLE IF NOT EXISTS user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    billing_address_id INT,
    shipping_address_id INT,
    token VARCHAR(255),
    role_id INT,
    FOREIGN KEY (billing_address_id) REFERENCES address (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (shipping_address_id) REFERENCES address (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla product
CREATE TABLE IF NOT EXISTS product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    img_url VARCHAR(255),
    description TEXT
);

-- Crear la tabla user_order
CREATE TABLE IF NOT EXISTS user_order (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    quantity INT,
    total_price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

ALTER TABLE user_order ADD COLUMN ref VARCHAR(255) NOT NULL;

ALTER TABLE user_order ADD COLUMN date DATETIME NOT NULL;

ALTER TABLE user_order ADD COLUMN total DECIMAL(10,2) NOT NULL;

-- Crear la tabla order_has_product
CREATE TABLE IF NOT EXISTS order_has_product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES user_order(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
