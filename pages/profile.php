<?php

// TASK 1 - PROFILE PAGE
// Your mission in this file:
// 1. Start a session and check login here. Include ../config/db.php for database queries.
// 2. Replace the sample username, email, and role with the current account details.
// 3. Read the account using the session user ID, not an ID sent in the URL.
// 4. Use htmlspecialchars when displaying account details.
// 5. Show management links only for a manager or director. Add a CSRF token to logout.

// TODO: Write your PHP code here.
require_once '../config/session.php';
require_once '../config/db.php';

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit();
}


// The HTML below uses sample data for the layout. Replace it as you complete the tasks.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WazFuli - Cyber Incident Evidence Vault">
    <title>Analyst profile | WazFuli</title>
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
        <div hidden role="alert" class="mb-6 rounded-xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-300">
            Your error message goes here.
        </div>

        <!-- TODO: Show this success box only when a session message exists; escape its text. -->
        <div hidden role="status" class="mb-6 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-300">
            Your success message goes here.
        </div>
        <div class="mb-8">
            <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">THE ANALYST BEHIND THE EVIDENCE</p>
            <h1 class="text-3xl font-semibold tracking-tight text-white">Your profile<span class="text-emerald-300">.</span></h1>
            <p class="mt-3 text-sm text-slate-400">Your identity in the WazFuli workspace.</p>
        </div>
        <!-- TASK 1: Use the logged-in account details and escape them here. -->
        <section class="max-w-2xl rounded-xl border border-slate-800 bg-slate-900/40 p-7">
            <div class="mb-7 flex items-center gap-4 border-b border-slate-800 pb-6">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-emerald-400/20 bg-emerald-400/10 text-lg text-emerald-300">WF</span>
                <div>
                    <h2 class="font-medium text-white"><?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <?php if($_SESSION['user']['role'] == 'analyst'){ ?>
                        <p class="mt-1 text-xs text-slate-500">System Analyst</p>
                    <?php } ?>

                </div>
            </div>
            <div class="mb-5">
                <label for="profile-username" class="mb-2 block text-xs text-slate-400">Username</label>
                <input id="profile-username" value="<?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>" readonly class="w-full rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm text-slate-300">
            </div>
            <div>
                <label for="profile-email" class="mb-2 block text-xs text-slate-400">Email address</label>
                <input id="profile-email" value="<?= htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8') ?>" readonly class="w-full rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm text-slate-300">
            </div>
        </section>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
