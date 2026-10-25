<?php

// TASK 3 - EDIT AN EVIDENCE NAME
// Your mission in this file:
// 1. Check login. Read and validate the file id from the URL.
// 2. Find the record and check that it belongs to the logged-in user.
// 3. Show an error if the file is missing or belongs to another account.
// 4. Replace the sample name, ID, and size with the real record.
// 5. Escape the file name before placing it in the input value.
// 6. Submit id and original_name to ../actions/doUpdate.php using POST.
// 7. Add CSRF tokens to Save and Logout. Show management links only to authorized roles.

// TODO: Write your PHP code here.
require_once '../config/session.php';
require_once '../config/db.php';

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit();
}

$fileId = $_GET['id'];
$q = "SELECT * FROM files WHERE id = :id AND user_id = :user_id";
$stmt = $conn->prepare($q);
$stmt->execute([
    'id' => $fileId,
    'user_id' => $_SESSION['user']['id']
]);
$file = $stmt->fetch();

// The HTML below uses sample data for the layout. Replace it as you complete the tasks.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WazFuli - Cyber Incident Evidence Vault">
    <title>Edit evidence | WazFuli</title>
    <link rel="icon" href="../assets/favicon.svg" type="image/svg+xml">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="../assets/script.js" defer></script>
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-200 antialiased selection:bg-emerald-300 selection:text-slate-950">
    <?php require_once __DIR__ . '/header.php'; ?>
    <main class="mx-auto max-w-6xl px-6 py-9 md:py-12">
        <p class="mb-6 text-[10px] tracking-widest text-amber-300">PRACTICE TEMPLATE / SAMPLE DATA</p>
        <!-- TASK: Show session messages once and escape their text. -->
        <!-- TODO: Show this error box only when a session message exists; escape its text. -->
        <?php if(isset($_SESSION['error'])){ ?>
        <div role="alert" class="mb-6 rounded-xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-300">
            <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['error']); } ?>

        <!-- TODO: Show this success box only when a session message exists; escape its text. -->
        <div hidden role="status" class="mb-6 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-300">
            Your success message goes here.
        </div>
        <div class="mb-8">
            <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">REFINE THE DETAILS</p>
            <h1 class="text-3xl font-semibold tracking-tight text-white">Rename evidence<span class="text-emerald-300">.</span></h1>
            <p class="mt-3 text-sm text-slate-400">Give your finding a clearer name. Keep the original extension.</p>
        </div>
        <section class="max-w-2xl rounded-xl border border-slate-800 bg-slate-900/40 p-7">
            <p class="mb-6 text-xs text-slate-500">Evidence <?= $file['id'] ?> · <?= number_format($file['file_size'] / 1024, 2) ?> KB</p>
            <form action="../actions/doUpdate.php" method="POST">
                <!-- TODO: Replace the sample ID with the matching database ID. -->
                <input type="hidden" name="id" value="<?= $file['id'] ?>">
                <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <label for="original_name" class="mb-2 block text-xs font-medium text-slate-300">File name</label>
                <input type="text" id="original_name" name="original_name" value="<?= htmlspecialchars($file['original_name'], ENT_QUOTES, 'UTF-8') ?>" maxlength="255" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-200 outline-none focus:border-emerald-400">
                <p class="mt-3 text-xs text-slate-500">This updates the display and download name. File contents stay unchanged.</p>
                <div class="mt-7 flex items-center justify-between border-t border-slate-800 pt-6">
                    <a href="list.php" class="text-xs text-slate-500 hover:text-white">Cancel</a>
                    <button type="submit" class="rounded-lg bg-emerald-300 px-6 py-3 text-xs font-semibold text-slate-950 hover:bg-emerald-200">Save changes</button>
                </div>
            </form>
        </section>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
