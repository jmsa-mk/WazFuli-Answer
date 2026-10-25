<?php

// TASK 2 - UPLOAD PAGE
// Your mission in this file:
// 1. Start a session and check login here before showing the form.
// 2. Send fileUpload to ../actions/doUpload.php using POST and multipart/form-data.
// 3. Add a CSRF token to the upload and logout forms.
// 4. Show a session error once if the upload fails. Escape the message.
// 5. The accept attribute only helps the file picker; validate the file again on the server.
// 6. Show management links only for a manager or director.

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
    <title>Upload evidence | WazFuli</title>
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
            <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">ADD TO THE INVESTIGATION</p>
            <h1 class="text-3xl font-semibold tracking-tight text-white">A new piece of evidence<span class="text-emerald-300">.</span></h1>
            <p class="mt-3 text-sm text-slate-400">Upload a screenshot, report, or log from your investigation.</p>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            <section class="rounded-xl border border-slate-800 bg-slate-900/40 p-7 lg:col-span-2">
                <h2 class="mb-6 text-sm font-medium text-white">Upload evidence</h2>
                <!-- TASK 2: Complete the upload handler; the form encoding is already provided. -->
                <form action="../actions/doUpload.php" method="POST" enctype="multipart/form-data">
                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <label for="fileUpload" class="relative flex cursor-pointer flex-col items-center rounded-xl border border-dashed border-emerald-400/30 bg-emerald-400/5 px-6 py-14 text-center hover:border-emerald-400/70 hover:bg-emerald-400/10">
                        <span class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-emerald-400/20 bg-emerald-400/10 text-emerald-300">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M12 16V3m-5 5 5-5 5 5M4 15v6h16v-6" />
                            </svg>
                        </span>
                        <span class="text-sm text-slate-300">Drop your evidence here or <span class="text-emerald-300">browse files</span></span>
                        <span class="mt-3 text-xs text-slate-500">JPG, PNG, PDF, TXT · Maximum 5 MB</span>
                        <input type="file" id="fileUpload" name="fileUpload" class="absolute inset-0 h-full w-full cursor-pointer opacity-0 focus:opacity-100">
                    </label>
                    <p id="selected-file" class="mt-4 break-all text-xs text-slate-400" role="status">No file selected.</p>
                    <div class="mt-7 flex items-center justify-between gap-4 border-t border-slate-800 pt-6">
                        <a href="list.php" class="text-xs text-slate-500 hover:text-white">Cancel</a>
                        <button type="submit" class="rounded-lg bg-emerald-300 px-6 py-3 text-xs font-semibold text-slate-950 hover:bg-emerald-200">Upload evidence &rarr;</button>
                    </div>
                </form>
            </section>
            <aside class="space-y-5">
                <section class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                    <p class="mb-4 text-[10px] tracking-widest text-emerald-400">EVIDENCE GUIDELINES</p>
                    <h2 class="text-base font-medium text-white">Keep your findings intact.</h2>
                    <ul class="mt-5 space-y-4 text-xs leading-6 text-slate-400">
                        <li>Use a descriptive filename to identify the finding later.</li>
                        <li>Keep individual files within the 5 MB upload limit.</li>
                        <li>Supported: screenshots, PDF reports, and plain text logs.</li>
                    </ul>
                </section>
                <div class="rounded-xl border border-emerald-400/15 bg-emerald-400/5 px-6 py-5 text-xs leading-6 text-emerald-200/70">Your evidence is linked to your analyst account.</div>
            </aside>
        </div>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
