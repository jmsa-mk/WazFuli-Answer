<?php

// TASK 1 - LOGIN PAGE
// Your mission in this file:
// 1. Start a session. If the user is already logged in, send them to index.php.
// 2. Read the saved username cookie, if it exists. Do not use it as proof of login.
// 3. Fill the username field and checkbox from that cookie.
// 4. Prepare a CSRF token. Show session messages once, then remove them.
// 5. Use htmlspecialchars for messages and form values. Keep the form action pointing to ../actions/doLogin.php.

// TODO: Write your PHP code here.
require_once '../config/session.php';
require_once '../config/db.php';

if(isset($_SESSION['user'])){
    header('Location: index.php');
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
    <title>Login | WazFuli</title>
    <link rel="icon" href="../assets/favicon.svg" type="image/svg+xml">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="../assets/script.js" defer></script>
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-200 antialiased selection:bg-emerald-300 selection:text-slate-950">
    <div class="grid min-h-screen lg:grid-cols-2">
        <aside class="relative flex flex-col justify-between overflow-hidden border-b border-slate-800 bg-slate-900/50 p-7 lg:border-b-0 lg:border-r lg:p-14">
            <a href="index.php" class="inline-flex items-center gap-3 text-2xl font-semibold tracking-tight text-white">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-emerald-400/25 bg-emerald-400/10 text-emerald-300">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="m12 3-8 3v6c0 4 8 9 8 9s8-5 8-9V6z" />
                        <path d="m8 12 3 3 5-6" />
                    </svg>
                </span>
                WazFuli<span class="-ml-3 text-emerald-300">.</span>
            </a>
            <div class="relative z-10 my-10 max-w-lg lg:my-20">
                <p class="mb-5 text-[10px] tracking-[0.3em] text-emerald-400">CYBER INCIDENT EVIDENCE VAULT</p>
                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-white lg:text-6xl">Every finding.<br>Every detail.<br><span class="text-emerald-300">Under your watch.</span></h1>
                <p class="mt-7 max-w-sm text-sm leading-7 text-slate-400">One focused workspace for the screenshots, reports, and logs behind your next investigation.</p>
                <div class="mt-8 flex flex-wrap gap-3 text-[10px] text-slate-500">
                    <span class="rounded-full border border-slate-700 px-3 py-1">DIGITAL EVIDENCE</span>
                    <span class="rounded-full border border-slate-700 px-3 py-1">ANALYST WORKSPACE</span>
                </div>
            </div>
            <p class="relative z-10 hidden text-[11px] text-slate-600 lg:block">WazFuli / Keep the evidence. Protect the investigation.</p>
            <div class="pointer-events-none absolute -bottom-44 -right-44 h-[450px] w-[450px] rounded-full border border-emerald-400/10 bg-emerald-400/[0.02]"></div>
        </aside>
        <main class="flex items-center justify-center px-7 py-14 lg:px-14">
            <div class="w-full max-w-sm">
                <p class="mb-5 text-[10px] tracking-widest text-amber-300">PRACTICE TEMPLATE / FRONTEND PREVIEW</p>
                <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">ANALYST ACCESS</p>
                <h2 class="text-3xl font-semibold tracking-tight text-white">Welcome back.</h2>
                <p class="mb-8 mt-3 text-sm leading-6 text-slate-500">Sign in to continue your investigation.</p>

                <!-- TASK 1: Escape error and success messages before displaying them. -->
                <!-- TODO: Show this error box only when a session message exists; escape its text. -->
                <?php if(isset($_SESSION['error'])){ ?>
                <div role="alert" class="mb-6 rounded-lg border border-red-400/20 bg-red-400/10 p-4 text-xs leading-6 text-red-300">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['error']); } ?>
                <!-- TODO: Show this success box only when a session message exists; escape its text. -->
                <?php if(isset($_SESSION['success'])){ ?>
                <div role="status" class="mb-6 rounded-lg border border-emerald-400/20 bg-emerald-400/10 p-4 text-xs leading-6 text-emerald-300">
                    <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['success']); } ?>
                

                <!-- TASK 1: Complete the registration handler for this POST form. -->
                <form action="../actions/doLogin.php" method="POST" class="space-y-5">
                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <div>
                        <label for="username" class="mb-2 block text-xs text-slate-300">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($_COOKIE['rememberUser'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="username" placeholder="Enter your username" maxlength="50" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-xs text-slate-300">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" autocomplete="current-password" placeholder="Enter your password" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 pr-16 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                            <button type="button" data-toggle-password="password" aria-label="Show password" aria-pressed="false" class="absolute inset-y-0 right-3 text-[10px] text-slate-500 hover:text-emerald-300">Show</button>
                        </div>

                    </div>
                    <label class="flex cursor-pointer items-center gap-2 text-xs text-slate-400">
                        <input type="checkbox" name="remember_username" value="1" class="h-3.5 w-3.5 accent-emerald-300">
                        Remember my username
                    </label>
                    <button type="submit" class="w-full rounded-lg bg-emerald-300 px-5 py-3.5 text-xs font-semibold text-slate-950 transition hover:bg-emerald-200">Sign in to WazFuli &rarr;</button>
                </form>
                <p class="mt-7 text-center text-xs text-slate-500">New to WazFuli? <a href="register.php" class="ml-1 text-emerald-300 hover:underline">Create account</a></p>
                <p class="mt-10 text-center text-[10px] text-slate-700">Secure Programming / PHP Native + MySQL</p>
            </div>
        </main>
    </div>
</body>
</html>
