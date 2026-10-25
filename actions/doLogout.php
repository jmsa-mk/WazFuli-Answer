<?php

// TASK 1 - HANDLE LOGOUT
// Your mission in this file:
// 1. Start the session. Accept POST requests only and check the CSRF token.
// 2. Clear the session data and remove the session cookie.
// 3. Destroy the session so private pages cannot be opened with the old login.
// 4. Redirect to ../pages/login.php and stop the script.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';

if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
    $_SESSION['error'] = 'Invalid CSRF token';
    header('Location: ../pages/register.php');
    exit();
}

session_destroy();
header('Location: ../pages/login.php');