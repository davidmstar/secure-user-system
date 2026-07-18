# Installation Guide

1. Install XAMPP and start Apache and MySQL.
2. Copy this project folder into the XAMPP htdocs directory.
3. Open phpMyAdmin at http://localhost/phpmyadmin/.
4. Create a database named secure_system.
5. Import the SQL file from sql/secure_system.sql.
6. Open http://localhost/SecureUserSystem/ in your browser.

## Troubleshooting
- If you see a database error, confirm that MySQL is running and that the database name matches secure_system.
- If the app cannot connect, verify the credentials in config/database.php.
- Ensure Apache and MySQL are both running in the XAMPP control panel.
