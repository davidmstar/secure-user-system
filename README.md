# Secure User Management and Contact System

A complete PHP 8+ web application for secure user registration, authentication, profile management, and contact message handling. The project is compatible with XAMPP and uses PDO, prepared statements, sessions, CSRF protection, and Bootstrap-styled responsive pages.

## Features
- Secure registration and login
- Password hashing with password_hash() and password_verify()
- Session-based authentication with regeneration
- Profile editing
- Contact form submission with validation
- Message submissions management with search, pagination, and delete
- Security information hub
- Modern responsive UI with Bootstrap and custom CSS

## Folder Structure
- assets/ - CSS, JavaScript, images
- config/ - database configuration
- includes/ - shared templates and auth middleware
- sql/ - database schema and sample data
- uploads/ - upload storage directory

## Installation
1. Place the project in XAMPP's htdocs directory.
2. Start Apache and MySQL in XAMPP.
3. Create the database by importing sql/secure_system.sql into phpMyAdmin or MySQL CLI.
4. Open http://localhost/SecureUserSystem/ in your browser.

## Default Login
- Email: admin@example.com
- Password: admin123

## Security Notes
- All database queries use PDO prepared statements.
- HTML output is escaped with htmlspecialchars().
- Forms include CSRF tokens.
- Passwords are never stored in plain text.
