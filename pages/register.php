<?php

// TASK 1 - REGISTRATION PAGE
// Your mission in this file:
// 1. Start a session. If the user is already logged in, send them to index.php.
// 2. Prepare a CSRF token for the form. Keep the POST action pointing to ../actions/doRegister.php.
// 3. Show an error or success message from the session, then remove that message.
// 4. Keep username and email after a failed submit. Never fill password fields from saved input.
// 5. Use htmlspecialchars when you display messages or values from the user.

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
    <title>Register | WazFuli</title>
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
                <p class="mb-3 text-[10px] tracking-[0.25em] text-emerald-400">JOIN THE WORKSPACE</p>
                <h2 class="text-3xl font-semibold tracking-tight text-white">Create your account.</h2>
                <p class="mb-8 mt-3 text-sm leading-6 text-slate-500">Your next investigation starts with a WazFuli account.</p>

                <!-- TASK 1: Escape error and success messages before displaying them. -->
                <!-- TODO: Show this error box only when a session message exists; escape its text. -->
                 <?php if(isset($_SESSION['error'])){ ?>
                <div role="alert" class="mb-6 rounded-lg border border-red-400/20 bg-red-400/10 p-4 text-xs leading-6 text-red-300">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['error']); } ?>

                <!-- TODO: Show this success box only when a session message exists; escape its text. -->
                <div hidden role="status" class="mb-6 rounded-lg border border-emerald-400/20 bg-emerald-400/10 p-4 text-xs leading-6 text-emerald-300">
                    Your success message goes here.
                </div>

                <!-- TASK 1: Complete the registration handler for this POST form. -->
                <form action="../actions/doRegister.php" method="POST" class="space-y-5">
                    <!-- TODO: Fill this value with the session CSRF token and check it in the action. -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <div>
                        <label for="username" class="mb-2 block text-xs text-slate-300">Username</label>
                        <input type="text" id="username" name="username" value="" autocomplete="username" placeholder="Choose an analyst username" maxlength="50" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-xs text-slate-300">Email address</label>
                        <input type="text" id="email" name="email" value="" autocomplete="email" placeholder="you@example.com" maxlength="100" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-xs text-slate-300">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" autocomplete="new-password" placeholder="Enter your password" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 pr-16 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                            <button type="button" data-toggle-password="password" aria-label="Show password" aria-pressed="false" class="absolute inset-y-0 right-3 text-[10px] text-slate-500 hover:text-emerald-300">Show</button>
                        </div>
                        <p class="mt-2 text-[10px] leading-5 text-slate-500">Min. 8 characters, with uppercase, lowercase, number, and symbol.</p>
                    </div>
                    <div>
                        <label for="confirm_password" class="mb-2 block text-xs text-slate-300">Confirm password</label>
                        <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" placeholder="Re-enter your password" required class="w-full rounded-lg border border-slate-700 bg-slate-900/50 px-4 py-3 text-sm outline-none placeholder:text-slate-600 focus:border-emerald-400">
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-emerald-300 px-5 py-3.5 text-xs font-semibold text-slate-950 transition hover:bg-emerald-200">Create account &rarr;</button>
                </form>
                <p class="mt-7 text-center text-xs text-slate-500">Already have an account? <a href="login.php" class="ml-1 text-emerald-300 hover:underline">Sign in</a></p>
            </div>
        </main>
    </div>
</body>
</html>
