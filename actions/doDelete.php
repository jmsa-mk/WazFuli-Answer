<?php

// TASK 3 AND 4 - DELETE EVIDENCE
// Your mission in this file:
// 1. Check login, allow POST only, and validate the CSRF token and file id.
// 2. Find the file and read the current user role from the database.
// 3. An analyst may delete only their own files. A manager or director may delete any file.
// 4. Check this permission on the server, even if the form button is hidden.
// 5. Use stored_name from the database to find the file inside ../uploads.
// 6. Delete the physical file and its database record. Handle errors without reporting false success.
// 7. Use scope only to choose the return page. It must never give the user extra permissions.
// 8. Return to ../pages/manageFiles.php for management requests, or ../pages/list.php for the personal vault.

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

if(!$_POST['id']){
    header('Location: ../pages/upload.php');
    exit();
}


$q = "SELECT id, role FROM users WHERE id = :user_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'user_id' => $_SESSION['user']['id']
]);

$user = $stmt->fetch();
$userId = $user['id'];
$role = $user['role'];
$fileId = $_POST['id'];


$q = "SELECT * FROM files f WHERE id = :file_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'file_id' => $fileId
]);
$file = $stmt->fetch();

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

$storedName = $file['stored_name'];
$q = "DELETE FROM files WHERE id = :file_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'file_id' => $fileId
]);
        
unlink('../uploads/' . $file['stored_name']);
header('Location: ../pages/list.php');
exit();





// echo '<pre>';
// print_r($stmt->fetchAll());
// echo '</pre>';



