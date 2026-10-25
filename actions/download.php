<?php

// TASK 3 - DOWNLOAD EVIDENCE
// Your mission in this file:
// 1. Check login. Read the file id from the URL and validate it as a positive integer.
// 2. Find the file in the database and check its user_id against the logged-in user.
// 3. Only the owner may download it. A manager role does not bypass this check.
// 4. Use stored_name from the database to find the file inside ../uploads.
// 5. Reject invalid paths and missing files. Never use a file path sent by the browser.
// 6. Send the file as an attachment using original_name as the download name.
// 7. Send download headers before output. Do not render file contents as HTML.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';

$fileId = $_GET['id'];

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


if($file['user_id'] != $_SESSION['user']['id']){
    $_SESSION['error'] = 'Access denied';
    header('Location: ../pages/list.php');
    exit();
}
$fileExtension = strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION));
$storedName = $file['stored_name'];
$file_path = '../uploads/' . $storedName;


header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file['original_name'] . '"');
header('Content-Length: ' . filesize($file_path));

readfile($file_path);
exit();