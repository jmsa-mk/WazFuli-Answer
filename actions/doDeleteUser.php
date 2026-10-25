<?php

// TASK 4 - DELETE A USER AND THEIR FILES
// Your mission in this file:
// 1. Check login and the current role. Only a manager or director may continue.
// 2. Accept POST only. Validate the CSRF token and target user id.
// 3. Find the target account. Reject a missing account, your own account, or any director account.
// 4. A manager or director may delete another analyst or manager.
// 5. Find every file owned by the target user. Use stored names from the database.
// 6. Delete the related file records before deleting the user, because files.user_id is a foreign key.
// 7. Also remove their physical files. Use a database transaction and handle failures clearly.
// 8. Make sure a deleted account cannot keep using an old session.
// 9. Return to ../pages/users.php with a success or error message.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';