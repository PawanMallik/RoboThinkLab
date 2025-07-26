CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert default admin (password: admin123)
INSERT INTO admins (username, password) VALUES (
    'admin',
    SHA2('admin123', 256)
);

-- Step 1: Create the database
-- CREATE DATABASE school_contacts;

-- Step 2: Use the new database
USE school_contacts;

-- Step 3: Create the table
CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gmail VARCHAR(150) NOT NULL,
    school_name VARCHAR(200) NOT NULL,
    country_code VARCHAR(10) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    role ENUM('Principal', 'Teacher') NOT NULL,
    address1 VARCHAR(255) NOT NULL,
    address2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    zip VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE queries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



ALTER TABLE submissions
ADD COLUMN remark ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending';

