<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=users', 'root', '');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fields = ['username', 'password', 'verifyPassword', 'first_name', 'last_name', 'email'];

        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("All fields are required!");
            }
        }

        $username = $_POST['username'];

        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            throw new Exception("Invalid username format. Use only letters, numbers, and underscores!");
        }

        $password = $_POST['password'];

        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long!");
        }

        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format!");
        }

        if ($password !== $_POST['verifyPassword']) {
            throw new Exception("Passwords do not match!");
        }


        $$checkQuery = $db->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
        $$checkQuery->execute([$username, $email]);
        $existingUser = $$checkQuery->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            throw new Exception("User Data is already registered!");
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $insertQuery = $db->prepare('INSERT INTO users (username, password, first_name, last_name, email) VALUES (?, ?, ?, ?, ?)');
        $insertQuery->execute([$username, $hashedPassword, $_POST['first_name'], $last_name, $_POST['email']]);

        echo "<div class='alert alert-success position-absolute text-center w-100'>Account created successfully!</div>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger position-absolute text-center w-100'>" . $e->getMessage() . "</div>";
} finally {
    session_destroy();
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Signup</title>

    <style>
        .form-control:focus,
        .form-select:focus,
        .form-check:focus {
            box-shadow: none;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card shadow w-100">
                <h3 class="text-center mt-3">Signup Page</h3>
                <div class="card-body">
                    <form method="post" action="Signup.php">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                        </div>
                                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="verify_password" placeholder="Verify Password" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-success w-100 me-2">Signup</button>
                            <a href="login-page.php" class="btn btn-outline-success w-100">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>