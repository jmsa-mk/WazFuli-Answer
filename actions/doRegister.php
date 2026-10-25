<?php

// TASK 1 - HANDLE REGISTRATION
// Your mission in this file:
// 1. Start a session and include ../config/db.php.
// 2. Accept POST requests only. Check the CSRF token from the form.
// 3. Read username, email, password, and confirm_password. Reject missing or invalid fields.
// 4. Username: 3-50 characters; use letters, numbers, dots, underscores, or hyphens.
// 5. Email: a valid address, at most 100 characters. Trim username/email, not the password.
// 6. Password: at least 8 characters, at most 72 bytes, with uppercase, lowercase, number, and symbol.
// 7. Make sure confirm_password matches password.
// 8. Check whether the username or email is already used. Use PDO prepared statements.
// 9. Hash the password and insert the account. Always set role to analyst, even if POST contains another role.
// 10. On success, redirect to ../pages/login.php with a session message.
// 11. On failure, return to ../pages/register.php with an error. Never save passwords in session messages.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $_SESSION['error'] = 'Invalid request';
    header('Location: ../pages/register.php');
    exit();
}

if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
    $_SESSION['error'] = 'Invalid CSRF token';
    header('Location: ../pages/register.php');
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$cpassword = $_POST['confirm_password'];

validateUsername($username);

if(strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['error'] = 'Invalid email';
    header('Location: ../pages/register.php');
    exit();
}

$q = "SELECT * FROM users WHERE username = :username OR email = :email";
$stmt = $conn->prepare($q);
$stmt->execute([
    'username' => $username,
    'email' => $email
]);

if($stmt->fetch()){
    $_SESSION['error'] = 'Username or email already exists';
    header('Location: ../pages/register.php');
    exit();
}

validatePassword($password);

if($password !== $cpassword){
    $_SESSION['error'] = 'Passwords do not match';
    header('Location: ../pages/register.php');
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$q = "INSERT INTO users(username, email, password, role) VALUES(:username, :email, :password, 'analyst')";
$stmt = $conn->prepare($q);
$stmt->execute([
    'username' => $username,
    'email' => $email,
    'password' => $hashedPassword
]);

$_SESSION['success'] = 'Registration successful';
header('Location: ../pages/login.php');

function validateUsername($data){
    if(strlen($data) < 3 || strlen($data) > 50){
        $_SESSION['error'] = 'Username must be between 3 and 50 characters';
        header('Location: ../pages/register.php');
        exit();
    }

    for($i = 0; $i < strlen($data); $i++){
        if(!ctype_alpha($data[$i]) && !ctype_digit($data[$i]) && $data[$i] != '.' && $data[$i] != '_' && $data[$i] != '-'){
            $_SESSION['error'] = 'Username contains invalid characters';
            header('Location: ../pages/register.php');
            exit();
        }
    }
}

function validatePassword($data){
    if(strlen($data) < 8 || strlen($data) > 72){
        $_SESSION['error'] = 'Password must be between 8 and 72 bytes';
        header('Location: ../pages/register.php');
        exit();
    }

    $upper = false;
    $lower = false;
    $number = false;
    $symbol = false;

    for($i = 0; $i < strlen($data); $i++){
        if(ctype_upper($data[$i])){
            $upper = true;
        }
        else if(ctype_lower($data[$i])){
            $lower = true;
        }
        else if(ctype_digit($data[$i])){
            $number = true;
        }
        else if(ctype_punct($data[$i])){
            $symbol = true;
        }
    }

    if(!$upper || !$lower || !$number || !$symbol){
        $_SESSION['error'] = 'Password must contain uppercase, lowercase, number, and symbol';
        header('Location: ../pages/register.php');
        exit();
    }

    return true;
}