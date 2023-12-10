# User Signup and Login System

## Signup.php
#### Description
This file provides a user interface for registering new users. It includes form validation for required fields such as first name, last name, username, password, verify password, and email. It ensures the following:

1- All fields are mandatory.
2- Validates username format (letters, numbers, underscores).
3- Password length must be at least 6 characters.
4- Validates email format.
5- Checks if the username or email already exists in the database before registration.

#### Usage
1- Ensure a MySQL database named 'users' exists.
2- Update the database credentials ('mysql:host=localhost;dbname=users', 'root') to match your environment.
3- Fill in the required details and click the 'Signup' button to create a new account.
4- If successful, a success message will be displayed; otherwise, any encountered errors will be shown.

## Login.php
#### Description
This file provides a user interface for logging in. It verifies user credentials against the registered users in the database and grants access if the credentials match.

#### Usage
1- Ensure the MySQL database 'users' exists and contains registered users.
2- Update the database credentials ('mysql:host=localhost;dbname=users', 'root') to match your environment.
3- Enter a registered username and its corresponding password.
4- Click the 'Login' button to submit the credentials for validation.
5- If the credentials are correct, a success message will confirm successful login; otherwise, any encountered errors will be displayed.