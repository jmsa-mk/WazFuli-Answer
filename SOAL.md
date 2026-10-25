# WazFuli - Secure Programming Exercise

**Tools:** PHP Native, MySQL

## Your mission

You are building WazFuli for a cyber security team. Analysts use it to keep
screenshots, reports, and logs from their investigations.

The pages are ready, but the backend is empty. Complete the numbered comments
in the PHP files. Do not change the folder structure or add a framework.
Use only the provided `users` and `files` tables.

Keep the existing form field names so the pages and actions work together.
Validate input on the server, use PDO prepared statements for user input, and
escape text with `htmlspecialchars` when displaying it in HTML.
Do not treat hidden inputs, cookies, or hidden buttons as proof of permission.

## TASK 1 - Accounts, sessions, and cookies (35 points)

**Files:** `config/db.php`, `pages/register.php`,
`actions/doRegister.php`, `pages/login.php`, `actions/doLogin.php`,
`pages/profile.php`, and `actions/doLogout.php`.

1. **Registration rules (10 points):** Require a username of 3-50 characters:
   letters, numbers, dots, underscores, or hyphens. Require a valid email of at
   most 100 characters. Require a password of at least 8 characters and at most
   72 bytes, with uppercase, lowercase, a number, and a symbol. Both passwords
   must match.
2. **Database storage (8 points):** Check duplicate usernames and emails.
   Hash passwords before saving them. New accounts must always be `analyst`,
   even if someone sends a different role in the request.
3. **Login (7 points):** Check the stored password hash. On success, change the
   session ID to prevent session fixation and save the user's identity in the
   session. On failure, return to login with an error.
4. **Private pages and logout (6 points):** Require login before opening private
   pages or actions. Show the current user's profile. Logout must remove the
   session data and session cookie.
5. **Remember username (4 points):** Save only the username for 7 days if the
   checkbox is checked. Remove the old cookie if unchecked. This cookie fills
   the login field; it must not log the user in.

Use POST for account forms. Create and check CSRF tokens for forms that change
data. A CSRF token is a random value saved in the session and sent with a form;
the action checks that the two values match.

**Expected result:** A valid user can register and log in. Invalid input and
duplicate accounts are rejected. Private pages require login again after logout.

## TASK 2 - Upload evidence (30 points)

**Files:** `pages/upload.php` and `actions/doUpload.php`.

| Extension | Real MIME type |
| --- | --- |
| JPG | image/jpeg |
| PNG | image/png |
| PDF | application/pdf |
| TXT | text/plain |

1. **Request checks (5 points):** Check login, POST, the CSRF token, and upload
   errors. The form field is `fileUpload`; the form uses `multipart/form-data`.
2. **File validation (10 points):** Allow 1 byte to 5 MB. Check that the extension
   and real MIME type match the table. Read the MIME on the server, not from
   the browser's `type` value.
3. **File storage (7 points):** Use a random stored name. Keep files in `uploads`.
   Create the folder if missing. Prevent direct access and script execution.
   Use Apache for the existing `.htaccess` setup.
4. **Save metadata (8 points):** Save the owner's user ID, original name, stored
   name, size in bytes, and MIME type in `files`. The database supplies the upload
   time. If saving the record fails, remove the file you just moved.

**Expected result:** A valid file appears in the owner's list. Empty files,
oversized files, and files with a false extension are rejected.

## TASK 3 - Read, update, download, and delete (35 points)

**Files:** `pages/index.php`, `pages/list.php`, `pages/edit.php`,
`actions/doUpdate.php`, `actions/download.php`, and `actions/doDelete.php`.

1. **Read (8 points):** JOIN `files` and `users` to show each file's owner.
   Show only the logged-in user's files in their vault. Show the real file
   count, total size, and five most recent files on the dashboard.
2. **Update (7 points):** Allow an owner to rename a file. Require 1-255
   characters, reject folder paths and control characters, and keep the same
   extension. Update `original_name` only.
3. **Download (7 points):** Validate the file ID and check ownership. Find the
   physical file using its stored name from the database. Send it as an
   attachment with its original name.
4. **Delete (8 points):** Allow POST only and check the CSRF token. An analyst
   may delete only their own files. Delete both the database record and the
   physical file. Handle failures and show a clear result.
5. **XSS prevention (5 points):** Escape dynamic text in the page, including
   names, emails, file names, messages, and input values.

**Expected result:** Analyst B cannot read, rename, download, or delete Analyst A's
file by changing an ID. HTML-like file names appear as text, not executable HTML.

## TASK 4 - Manage users and roles (extra practice)

**Files:** `pages/users.php`,
`pages/manageFiles.php`, `actions/doChangeRole.php`, `actions/doDeleteUser.php`,
and `actions/doDelete.php`.

The `role` column is already in `database.sql`. Do not add another table.

| Database value | Display name | Permissions |
| --- | --- | --- |
| analyst | Security Analyst | Manage their own evidence. |
| manager | SOC Manager | Manage users and delete any user's files. |
| director | SOC Director | Main admin with management access and a protected account. |

1. After completing registration, register your main admin account. Use
   phpMyAdmin to change only that account's role to `director`. Keep the
   hashed password from registration. Public registration must still create analysts.
2. Allow Manager and Director to view all users and file metadata, including
   users with no files.
3. Allow them to grant or remove the Manager role for other Analyst/Manager
   accounts. The new role can only be `analyst` or `manager`.
4. Allow them to delete other Analyst/Manager accounts and all of those users'
   files. Delete file records before the user to respect the foreign key.
5. Do not allow deleting your own account or a Director. Do not allow changing
   your own role, changing a Director's role, or granting Director through a form.
6. Write session and role checks directly in each private page and action.
   Read the current account and role from the database on each private request.
   Deleted users and demoted managers must lose access even with an old session.
7. Check POST, CSRF, and permissions in every management action. Handle database
   and physical file deletion failures. Use a transaction for related database
   changes.
8. Personal file lists, rename, and download stay owner-only. Managers and
   Directors get the extra ability to delete any file.

**Expected result:** A Director can delete a Manager. A Manager cannot delete or
demote a Director, even with a manually changed request. Analysts cannot open
management pages or call management actions.

## Test your work

- Register with valid data, invalid email, weak password, and duplicate details.
- Log in with the right and wrong password. Confirm the session ID changes on success.
- Log out, then try to open a private page directly.
- Upload valid JPG/PNG/PDF/TXT files, an empty file, a file over 5 MB, and a fake JPG.
- Create two analysts. Try changing IDs to access the other analyst's files.
- Rename a file with HTML-like text and check that no script runs.
- Submit a changing action without a valid CSRF token and try Delete through GET.
- For Task 4, test Director protection, fake roles, demotion, and deleted accounts.

## Submit

Submit the completed PHP files in the same folders, the database schema, and
your test results. The comments describe what to build; they are not completed
solutions.
