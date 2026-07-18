CREATE DATABASE IF NOT EXISTS secure_system;
USE secure_system;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_contact_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (username, fullname, email, password, role) VALUES
('admin', 'System Administrator', 'admin@example.com', '$2y$10$K8T1hMzz0x8vP5c2u0Vw4uYjObn1hv0j8kWv2YdV0kigCE6Kn1b1C', 'admin'),
('jane', 'Jane Doe', 'jane@example.com', '$2y$10$Q1s0l0m0s4pQ9oJYjR7H3uP4f1yEWfY1l4b9r4ZLT0VYT6V5Y6j6', 'user');

INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES
(2, 'John Smith', 'john@example.com', 'Project Feedback', 'The dashboard looks excellent and the security sections are helpful.'),
(2, 'Helen Brown', 'helen@example.com', 'Need Help', 'Could you add more detailed statistics on the dashboard?');
