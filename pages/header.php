<?php

// TASK 1 AND 4 - SHARED HEADER
// Your mission in this file:
// 1. Start the session and check login in each page BEFORE including this header.
// 2. Show Users and Manage files only for SOC Manager or SOC Director.
// 3. Fill the logout token from the session. Escape its value before displaying it.
// 4. Check that token in ../actions/doLogout.php before ending the session.
// 5. Keep access checks in each private page and action; hiding links is not enough.

// TODO: Complete the role condition and logout token in the HTML below.

require_once '../config/session.php';
require_once '../config/db.php';


?>
<header class="border-b border-slate-800/80 bg-slate-950">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-5 px-6 py-5">
        <a href="index.php" class="inline-flex items-center gap-3 text-2xl font-semibold tracking-tight text-white">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-emerald-400/25 bg-emerald-400/10 text-emerald-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="m12 3-8 3v6c0 4 8 9 8 9s8-5 8-9V6z" />
                    <path d="m8 12 3 3 5-6" />
                </svg>
            </span>
            WazFuli<span class="-ml-3 text-emerald-300">.</span>
        </a>
        <nav class="flex flex-wrap items-center gap-1 text-xs" aria-label="Main navigation">
            <a href="index.php" class="rounded-lg px-4 py-2 transition text-slate-400 hover:bg-slate-800 hover:text-white">Dashboard</a>
            <a href="list.php" class="rounded-lg px-4 py-2 transition text-slate-400 hover:bg-slate-800 hover:text-white">Evidence</a>
            <a href="upload.php" class="rounded-lg px-4 py-2 transition text-slate-400 hover:bg-slate-800 hover:text-white">Upload</a>
            <a href="profile.php" class="rounded-lg px-4 py-2 transition text-slate-400 hover:bg-slate-800 hover:text-white">Profile</a>

            <!-- TODO: Start a role condition here. Allow only manager or director. -->
             <?php if($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'director'){ ?>
            <a href="users.php" class="rounded-lg px-4 py-2 text-emerald-300 hover:bg-emerald-400/10">Users</a>
            <a href="manageFiles.php" class="rounded-lg px-4 py-2 text-emerald-300 hover:bg-emerald-400/10">Manage files</a>
            <?php } ?>
            <!-- TODO: End the role condition here. -->

            <form action="../actions/doLogout.php" method="POST" class="ml-2">
                <!-- TODO: Fill this value with the session CSRF token and escape it. -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="rounded-lg border border-slate-700 px-4 py-2 text-slate-400 transition hover:border-slate-500 hover:text-white">Logout</button>
            </form>
        </nav>
    </div>
</header>
