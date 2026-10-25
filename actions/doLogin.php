<?php

// TASK 1 - HANDLE LOGIN
// Your mission in this file:
// 1. Start a session and include ../config/db.php.
// 2. Accept POST requests only. Validate the CSRF token, username, and password.
// 3. Find the user by username using a PDO prepared statement.
// 4. Check the password against the saved hash.
// 5. If login succeeds, change the session ID to prevent session fixation.
// 6. Save the user ID, username, email, and role in the session. Do not save the password.
// 7. If remember_username is checked, save only the username in a cookie for 7 days.
// 8. If it is unchecked, remove the old username cookie. A cookie must not log the user in.
// 9. Use appropriate cookie settings: HttpOnly, SameSite, and Secure when using HTTPS.
// 10. Redirect to ../pages/index.php on success, or ../pages/login.php with an error on failure.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $_SESSION['error'] = 'Invalid request';
    header('Location: ../pages/login.php');
    exit();
}

if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
    $_SESSION['error'] = 'Invalid CSRF token';
    header('Location: ../pages/register.php');
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];
$rememberMe = $_POST['remember_username'];

$q = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($q);
$stmt->execute([
    'username' => $username
]);


if($stmt->rowCount() > 0){
    $user = $stmt->fetch();
    if(password_verify($password, $user['password'])){
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        if(isset($rememberMe)){
            $expire = time() + (7 * 24 * 60 * 60);
            setcookie("rememberUser", $user['username'], [
                'expires' => $expire,
                'path' => '/',
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ]);
        }
        else{
            setcookie("rememberUser", "", [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ]);
        }


        header('Location: ../pages/index.php');
        exit();       
    }
}



$_SESSION['error'] = 'Wrong username or password combination';
header('Location: ../pages/login.php');