<?php

// TASK 3 - RENAME EVIDENCE
// Your mission in this file:
// 1. Check login, allow POST only, and validate the CSRF token.
// 2. Read id and original_name from the form. The ID must be a positive integer.
// 3. Find the file and check that it belongs to the logged-in user.
// 4. The new name must be 1-255 characters, without folder paths or control characters.
// 5. Keep the original extension. Change only original_name, not stored_name or the file contents.
// 6. Update the record with a PDO prepared statement. Check ownership in the update as well.
// 7. Return to ../pages/list.php with a success message, or the edit page with an error.

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
    header('Location: ../pages/login.php');
    exit();
}

$fileId = $_POST['id'];
$fileName = $_POST['original_name'];

if($fileId < 0){
    header('Location: ../pages/list.php');
    exit();
}

$q = "SELECT * FROM files WHERE id = :file_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'file_id' => $fileId
]);

$file = $stmt->fetch();

if(!$file){
    $_SESSION['error'] = 'File not found';
    header('Location: ../pages/list.php');
    exit();
}

$q = "SELECT role FROM users WHERE id = :user_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'user_id' => $_SESSION['user']['id']
]);

$user = $stmt->fetch();
$role = $user['role'];
$userId = $_SESSION['user']['id'];

if($role == 'analyst'){
    if($file['user_id'] != $userId){
        $_SESSION['error'] = 'Access denied';
        header('Location: ../pages/list.php');
        exit();
    }
}
else if($role == 'manager' || $role == 'director'){
    // ALLOWED
}
else{
    $_SESSION['error'] = 'Access denied';
    header('Location: ../pages/list.php');
    exit();
}


if(strlen($fileName) < 1 || strlen($fileName) > 255){
    $_SESSION['error'] = 'File name must be between 1 and 255 characters';
    header('Location: ../pages/edit.php');
    exit();
}


$oldExtension = strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION));
$newExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if($oldExtension !== $newExtension){
    $_SESSION['error'] = 'File extension cannot be changed';
    header('Location: ../pages/edit.php?id=' . $fileId);
    exit();
}

$q = "UPDATE files SET original_name = :original_name WHERE id = :file_id AND user_id = :user_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'original_name' => $fileName,
    'file_id' => $fileId,
    'user_id' => $_SESSION['user']['id']
]);

$_SESSION['success'] = 'Evidence renamed successfully';
header('Location: ../pages/list.php');
exit();