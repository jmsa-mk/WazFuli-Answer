<?php

// TASK 4 - MANAGE ALL EVIDENCE
// Your mission in this file:
// 1. Check login and allow only SOC Manager and SOC Director.
// 2. Read all file records and JOIN users to show the owner username.
// 3. Replace the sample row with a loop. Display the real count and an empty-state message.
// 4. Escape every text value from the database.
// 5. Set the real file ID in the Delete form and add a CSRF token.
// 6. Keep scope set to management so the action can return here.
// 7. Do not use scope to check permissions. The action must check the current role itself.

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
    <title>File management | WazFuli</title>
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
            <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">SECURITY OPERATIONS / FILE MANAGEMENT</p>
            <h1 class="text-3xl font-semibold tracking-tight text-white">All evidence<span class="text-emerald-300">.</span></h1>
            <p class="mt-3 text-sm text-slate-400">View and delete evidence from all accounts. Download and rename stay in the owner vault.</p>
        </div>
        <section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/30">
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-5">
                <h2 class="text-sm font-medium text-white">All files <span class="ml-2 text-xs text-slate-500">1</span></h2>
                <label class="w-full sm:w-64">
                    <span class="sr-only">Search filename or owner</span>
                    <input type="search" data-table-search placeholder="Search filename or owner…" class="w-full rounded-lg border border-slate-700 bg-slate-950/50 px-4 py-2 text-xs outline-none focus:border-emerald-400">
                </label>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-y border-slate-800 bg-slate-900/70 text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">File name</th>
                            <th scope="col" class="px-5 py-4 font-medium">Owner</th>
                            <th scope="col" class="px-5 py-4 font-medium">Type / Size</th>
                            <th scope="col" class="px-5 py-4 font-medium">Uploaded</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/70">
                        <!-- TODO: Replace this sample row with a loop over the database results; escape text values. -->
                        <tr data-filter-row data-search="incident-report.pdf sample_analyst" class="hover:bg-slate-800/30">
                            <td class="px-6 py-5 text-slate-200">incident-report.pdf</td>
                            <td class="px-5 py-5 text-emerald-300">sample_analyst</td>
                            <td class="px-5 py-5 text-slate-400">
                                application/pdf
                                <p class="mt-1 text-[10px] text-slate-600">256.0 KB</p>
                            </td>
                            <td class="whitespace-nowrap px-5 py-5 text-slate-500">2026-10-24 09:00</td>
                            <td class="px-6 py-5 text-right">
                                <form action="../actions/doDelete.php" method="POST" data-confirm-delete>
                                    <!-- TODO: Replace the sample ID with the matching database ID. -->
                                    <input type="hidden" name="id" value="101">
                                    <input type="hidden" name="scope" value="management">
                                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                                    <input type="hidden" name="csrf_token" value="">
                                    <button type="submit" class="rounded-md border border-red-400/20 px-3 py-2 text-red-400 hover:bg-red-400/10">Delete file</button>
                                </form>
                            </td>
                        </tr>
                        <!-- TODO: End your loop here. -->
                        <!-- TODO: Show this row only when the file list is empty. -->
                        <tr hidden><td colspan="5" class="px-6 py-16 text-center text-slate-500">No files uploaded.</td></tr>
                    </tbody>
                </table>
                <p data-no-results hidden class="px-6 py-12 text-center text-xs text-slate-500">No files match your search.</p>
            </div>
        </section>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
