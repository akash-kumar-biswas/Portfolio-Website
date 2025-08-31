CREATE DATABASE IF NOT EXISTS portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE portfolio;

CREATE TABLE IF NOT EXISTS projects (     -- projects table
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  technologies VARCHAR(255),
  image_file VARCHAR(255),               
  github_link VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_users (  -- admins table (with remember-me token for cookies)
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  remember_token VARCHAR(64) DEFAULT NULL,
  remember_expiry DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE skills (             --skill table
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL,   
    name VARCHAR(100) NOT NULL,       
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
