<?php

// TASK 4 - CHANGE A USER ROLE
// Your mission in this file:
// 1. Check login and read the current role from the database.
// 2. Allow only SOC Manager and SOC Director. Accept POST and validate the CSRF token.
// 3. Validate the target user id and find that account.
// 4. The new role may be analyst or manager only. Never accept director from the form.
// 5. Do not allow changing your own role or the role of a SOC Director.
// 6. Update the target role using a PDO prepared statement.
// 7. Make sure a demoted manager loses management access on their next request.
// 8. Return to ../pages/users.php with a success or error message.

// TODO: Write your PHP code here.

require_once '../config/session.php';
require_once '../config/db.php';