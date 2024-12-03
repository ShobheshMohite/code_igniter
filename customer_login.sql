-- Create DB
CREATE DATABASE customer_login;

-- Use DB
USE customer_login;

-- Create table for states
CREATE TABLE states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO states (name) VALUES 
('Maharashtra'), 
('Rajsthan'), 
('Goa'), 
('Karnatak'), 
('Delhi');

-- Create table for cities
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    state_id INT NOT NULL,
    FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE
);

INSERT INTO cities (name, state_id) VALUES
('Satara', 1), 
('Pune', 1),
('Jaipur', 2),
('Jodhpur', 2),
('Panjim', 3),
('Margaon', 3),
('Bengluru', 4),
('Maysur', 4),
('Burari', 5),
('Delhi', 5);

CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    lastname VARCHAR(50) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    dob DATE NOT NULL,
    mobile VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    state_id INT NOT NULL,
    city_id INT NOT NULL,
    FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE
);
