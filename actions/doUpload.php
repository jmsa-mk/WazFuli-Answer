<?php

// TASK 2 - UPLOAD EVIDENCE
// Your mission in this file:
// 1. Start a session, check login, and include ../config/db.php. Accept POST and check the CSRF token.
// 2. Read the uploaded file from fileUpload. Check upload errors and that a file was actually uploaded.
// 3. Allow a size from 1 byte to 5 MB. Allow only JPG, PNG, PDF, and TXT.
// 4. Check both the extension and the real MIME type on the server. Do not trust the browser file type.
// 5. Reject invalid file names and paths. Generate a new, random stored_name.
// 6. Use the existing ../uploads folder, or create it if missing. Prevent direct access and script execution.
// 7. Move the uploaded file into that folder.
// 8. Insert user_id, original_name, stored_name, file_size, and file_type into files.
// 9. Use the user ID from the session and a PDO prepared statement. Store the real MIME in file_type.
// 10. If the database insert fails, remove the file that was just moved.
// 11. Redirect to ../pages/list.php on success, or ../pages/upload.php with an error on failure.

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

// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// die();

$file = $_FILES['fileUpload'];
$fileName = $file['name'];
$fileType = $file['type'];
$fileTmp = $file['tmp_name'];
$fileError = $file['error'];
$fileSize = $file['size'];

if($fileError === UPLOAD_ERR_NO_FILE){
    $_SESSION['error'] = 'Please select a file';
    header('Location: ../pages/upload.php');
    exit();
}

if($fileError !== UPLOAD_ERR_OK){
    $_SESSION['error'] = 'Upload failed';
    header('Location: ../pages/upload.php');
    exit();
}

$maxSize = 5 * 1024 * 1024;
if($fileSize > $maxSize){
    $_SESSION['error'] = 'Maximum file size is 5 MB';
    header('Location: ../pages/upload.php');
    exit();
}

$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedTypes = [
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'pdf' => 'application/pdf',
    'txt' => 'text/plain'
];
$mediaType = mime_content_type($fileTmp);

if(!isset($allowedTypes[$fileExtension])){
    $_SESSION['error'] = 'Invalid file extension';
    header('Location: ../pages/upload.php');
    exit();
}

if($allowedTypes[$fileExtension] !== $mediaType) {
    $_SESSION['error'] = 'Invalid MIME type';
    header('Location: ../pages/upload.php');
    exit();
}

if(!is_dir('../uploads/')){
    mkdir('../uploads');
}



$storedName = time() . '_' . bin2hex(random_bytes(16)) . '.' . $fileExtension;
move_uploaded_file($fileTmp, '../uploads/' . $storedName);

try{
    $q = "INSERT INTO files(user_id, original_name, stored_name, file_size, file_type) VALUES(:user_id, :original_name, :stored_name, :file_size, :file_type)";
    $stmt = $conn->prepare($q);
    $stmt->execute([
        'user_id' => $_SESSION['user']['id'],
        'original_name' => $fileName,
        'stored_name' => $storedName,
        'file_size' => $fileSize,
        'file_type' => $mediaType
    ]);
}catch(PDOException $e){
    unlink('../uploads/' . $storedName);
    $_SESSION['error'] = 'Failed to save file information';
    header('Location: ../pages/upload.php');
    exit();
}

$_SESSION['success'] = 'File uploaded successfully';
header('Location: ../pages/list.php');
exit();

// array(1) {
//   ["fileUpload"]=>
//   array(6) {
//     ["name"]=>
//     string(40) "2610_COMP6695001__Test_Project_1 (1).pdf"
//     ["full_path"]=>
//     string(40) "2610_COMP6695001__Test_Project_1 (1).pdf"
//     ["type"]=>
//     string(15) "application/pdf"
//     ["tmp_name"]=>
//     string(44) "C:\Users\user\AppData\Local\Temp\php8A99.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(154898)
//   }
// }