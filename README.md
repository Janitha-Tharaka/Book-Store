# Book-Store
This is created using CodeIgniter framework.

## Book Store - Installation Guide

### System Requirements:

- Make sure you have PHP installed on your local machine.
- Install a web server (such as Apache) or use a local development environment like XAMPP or WAMP that includes a web server, PHP, and MySQL.

### Download and Extract the Project:

1. Download the project files from this [GitHub repository](https://github.com/Janitha-Tharaka/Book-Store) or copy the project directory to your local machine.
2. Extract the project files if they are in a compressed format (e.g., ZIP).

### Database Setup:

1. Create a new database for your project (e.g., `book_store`).
2. Import the provided database schema.
3. Configure the database connection settings in CodeIgniter's configuration file (`application/config/database.php`).

### Test the Application:

1. Access the project through the configured URL in your web browser.
2. Make sure the application is working correctly and there are no error messages.

### Assumptions and Main Points to Consider:

- The user is found by the session ID, so the data will be browser-specific.
- Only one session ID can go through the process once to finish quickly.
- Both categories must have at least 10 books to qualify for a 5% discount.

Enjoy using the Book Store application!

