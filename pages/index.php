<?php

// TASK 1 AND 3 - DASHBOARD
// Your mission in this file:
// 1. Start a session and check login before showing this page. Include ../config/db.php.
// 2. Replace the sample username with the logged-in user name.
// 3. Count that user's files and add their file sizes for the summary cards.
// 4. Read their five most recent files and display them in the table.
// 5. Use htmlspecialchars for text values and show a message if there are no files.
// 6. Show Users and Manage files links only for a manager or director.
// 7. Add a CSRF token to the logout form.

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
    <title>Dashboard | WazFuli</title>
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
        <div class="mb-9 flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="mb-3 text-[10px] font-medium tracking-[0.25em] text-emerald-400">ANALYST WORKSPACE</p>
                <h1 class="text-3xl font-semibold tracking-tight text-white md:text-4xl">Your evidence. In focus.</h1>
                <p class="mt-3 text-sm text-slate-400">
                    Welcome back, <span class="text-slate-200">sample_analyst</span>.
                    Ready for your next investigation?
                </p>
            </div>
            <a href="upload.php" class="rounded-lg bg-emerald-300 px-5 py-3 text-xs font-semibold text-slate-950 hover:bg-emerald-200">+ Upload evidence</a>
        </div>

        <section class="mb-7 grid gap-4 sm:grid-cols-3" aria-label="Evidence summary">
            <div class="rounded-xl border border-slate-800 bg-slate-900/50 p-6">
                <p class="text-xs text-slate-400">Evidence in your vault</p>
                <p class="mt-4 text-4xl font-medium tracking-tight text-white">1</p>
                <p class="mt-3 text-[11px] text-slate-500">Files collected for investigation</p>
            </div>
            <div class="rounded-xl border border-slate-800 bg-slate-900/50 p-6">
                <p class="text-xs text-slate-400">Total evidence size</p>
                <p class="mt-4 text-4xl font-medium tracking-tight text-white">
                    0.25<span class="ml-2 text-base text-slate-500">MB</span>
                </p>
                <p class="mt-3 text-[11px] text-slate-500">Maximum 5 MB per file</p>
            </div>
            <div class="rounded-xl border border-emerald-400/20 bg-emerald-400/5 p-6">
                <p class="text-xs text-emerald-200/70">Analyst access</p>
                <p class="mt-5 flex items-center gap-3 text-2xl font-medium text-emerald-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span> Layout preview
                </p>
                <p class="mt-4 text-[11px] text-slate-500">Your personal evidence workspace</p>
            </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/30">
            <div class="flex items-center justify-between gap-4 border-b border-slate-800 px-6 py-5">
                <div>
                    <h2 class="text-sm font-semibold text-white">Recent evidence</h2>
                    <p class="mt-1 text-xs text-slate-500">The latest additions to your investigation.</p>
                </div>
                <a href="list.php" class="text-xs text-emerald-300 hover:text-emerald-200">View all &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-900/60 text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">File name</th>
                            <th scope="col" class="px-6 py-4 font-medium">Size</th>
                            <th scope="col" class="px-6 py-4 font-medium">Uploaded</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/70">
                        <!-- TODO: Replace this sample row with a loop over the database results; escape text values. -->
                        <tr class="hover:bg-slate-800/30">
                            <td class="px-6 py-5 font-medium text-slate-200">incident-report.pdf</td>
                            <td class="whitespace-nowrap px-6 py-5 text-slate-400">256.0 KB</td>
                            <td class="whitespace-nowrap px-6 py-5 text-slate-500">2026-10-24 09:00</td>
                            <td class="px-6 py-5 text-right"><a href="../actions/download.php?id=101" class="text-emerald-300 hover:underline">Download</a></td>
                        </tr>
                        <!-- TODO: End your loop here. -->
                        <!-- TODO: Show this row only when the file list is empty. -->
                        <tr hidden>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-500">
                                No evidence yet. <a href="upload.php" class="text-emerald-300">Upload your first finding.</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mt-7 flex flex-wrap items-center justify-between gap-6 rounded-xl border border-slate-800 bg-gradient-to-r from-slate-900 to-slate-950 px-7 py-7">
            <div>
                <p class="mb-2 text-[10px] tracking-widest text-emerald-400">COLLECT. DOCUMENT. INVESTIGATE.</p>
                <h2 class="text-lg font-medium text-white">Every file tells part of the story.</h2>
                <p class="mt-2 max-w-lg text-xs leading-6 text-slate-500">Keep screenshots, incident reports, and logs together in your personal evidence vault.</p>
            </div>
            <a href="list.php" class="rounded-lg border border-slate-700 px-5 py-3 text-xs text-slate-300 hover:border-emerald-400/50 hover:text-emerald-300">Open evidence vault &rarr;</a>
        </section>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
