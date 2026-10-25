<?php

// TASK 4 - USER MANAGEMENT PAGE
// Your mission in this file:
// 1. Start a session, check login, and read the current role using ../config/db.php.
// 2. Allow only SOC Manager and SOC Director, including when this URL is opened directly.
// 3. Read the users and their file counts. Include users with no files.
// 4. Replace the sample rows with a loop and escape username, email, and role labels.
// 5. Do not show Change role or Delete for your own account or a director.
// 6. Set the target user ID in each form and add a CSRF token.
// 7. The action files must check these permissions again. Hidden buttons do not protect an endpoint.

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
    <title>User management | WazFuli</title>
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
        <div class="mb-8 flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">SECURITY OPERATIONS / ACCESS MANAGEMENT</p>
                <h1 class="text-3xl font-semibold tracking-tight text-white">User management<span class="text-emerald-300">.</span></h1>
                <p class="mt-3 text-sm text-slate-400">Manage analyst accounts and grant SOC Manager access.</p>
            </div>
            <span class="rounded-lg border border-emerald-400/20 bg-emerald-400/5 px-4 py-2 text-xs text-emerald-300">SOC Manager</span>
        </div>

        <div class="mb-6 rounded-xl border border-amber-400/20 bg-amber-400/5 px-5 py-4 text-xs leading-6 text-amber-200/80">
            The SOC Director is the main admin. This account must be protected from deletion and role changes.
            Deleting a user must also delete their files. You cannot delete your own account.
        </div>

        <section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/30">
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-5">
                <h2 class="text-sm font-medium text-white">User accounts <span class="ml-2 text-xs text-slate-500">2</span></h2>
                <label class="w-full sm:w-64">
                    <span class="sr-only">Search username or email</span>
                    <input type="search" data-table-search placeholder="Search username or email…" class="w-full rounded-lg border border-slate-700 bg-slate-950/50 px-4 py-2 text-xs outline-none focus:border-emerald-400">
                </label>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-y border-slate-800 bg-slate-900/70 text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">User</th>
                            <th scope="col" class="px-5 py-4 font-medium">Role</th>
                            <th scope="col" class="px-5 py-4 font-medium">Files</th>
                            <th scope="col" class="px-5 py-4 font-medium">Change role</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/70">
                        <!-- TODO: Replace this sample row with a loop over the database results; escape text values. -->
                        <tr data-filter-row data-search="sample_analyst analyst@example.com" class="hover:bg-slate-800/30">
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-200">sample_analyst</p>
                                <p class="mt-1 text-[11px] text-slate-500">analyst@example.com</p>
                            </td>
                            <td class="px-5 py-5">
                                <span class="whitespace-nowrap rounded-md border border-slate-700 px-2 py-1 text-emerald-300">Security Analyst</span>
                            </td>
                            <td class="px-5 py-5 text-slate-400">1</td>
                            <td class="px-5 py-5">
                                <!-- TODO: Hide this form for your own account and any director. Check again in the action. -->
                                <form action="../actions/doChangeRole.php" method="POST" class="flex items-center gap-2">
                                    <!-- TODO: Replace the sample ID with the matching database ID. -->
                                    <input type="hidden" name="id" value="2">
                                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                                    <input type="hidden" name="csrf_token" value="">
                                    <label class="sr-only" for="role-2">Role for sample_analyst</label>
                                    <select id="role-2" name="role" class="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-xs">
                                        <option value="analyst" selected>Security Analyst</option>
                                        <option value="manager">SOC Manager</option>
                                    </select>
                                    <button type="submit" class="rounded-md bg-emerald-400/10 px-3 py-2 text-emerald-300 hover:bg-emerald-400/20">Save</button>
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <!-- TODO: Hide this form for your own account and any director. Check again in the action. -->
                                <form action="../actions/doDeleteUser.php" method="POST" data-confirm-delete data-confirm-message="Delete this user and all their files? This cannot be undone.">
                                    <!-- TODO: Replace the sample ID with the matching database ID. -->
                                    <input type="hidden" name="id" value="2">
                                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                                    <input type="hidden" name="csrf_token" value="">
                                    <button type="submit" class="whitespace-nowrap rounded-md border border-red-400/20 px-3 py-2 text-red-400 hover:bg-red-400/10">Delete user</button>
                                </form>
                            </td>
                        </tr>
                        <!-- TODO: End your loop here. -->
                        <!-- Sample protected account. Build this state from the real role in your loop. -->
                        <tr data-filter-row data-search="sample_director director@example.com" class="hover:bg-slate-800/30">
                            <td class="px-6 py-5">
                                <p class="font-medium text-slate-200">sample_director</p>
                                <p class="mt-1 text-[11px] text-slate-500">director@example.com</p>
                            </td>
                            <td class="px-5 py-5">
                                <span class="whitespace-nowrap rounded-md border border-slate-700 px-2 py-1 text-amber-300">SOC Director</span>
                            </td>
                            <td class="px-5 py-5 text-slate-400">0</td>
                            <td class="px-5 py-5 text-slate-600">Protected role</td>
                            <td class="px-6 py-5 text-right text-slate-600">Protected</td>
                        </tr>
                    </tbody>
                </table>
                <p data-no-results hidden class="px-6 py-12 text-center text-xs text-slate-500">No users match your search.</p>
            </div>
        </section>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap justify-between gap-3 border-t border-slate-800/70 px-6 py-6 text-[11px] text-slate-600">
        <span>WazFuli / Cyber Incident Evidence Vault</span>
        <span>Keep the evidence. Protect the investigation.</span>
    </footer>
</body>
</html>
