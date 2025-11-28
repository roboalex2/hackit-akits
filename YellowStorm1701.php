<?php
// flag2.php
// Second stage: requires tampering with the "role" cookie to become admin.

session_start();
require __DIR__ . '/config.php';

// Reset / clear session + cookies
if (isset($_GET['reset'])) {
    $_SESSION = [];
    if (session_id() !== '') {
        session_destroy();
    }

    setcookie('username', '', time() - 3600, '/');
    setcookie('role', '', time() - 3600, '/');

    exit;
}

// Read cookies set during login
$username = $_COOKIE['username'] ?? null;
$role     = $_COOKIE['role'] ?? null;

// Second flag, again ending with .php
$FLAG2 = 'FLAG{EndOfLine.php}';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CTF – Role Check</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            color: #e5e7eb;
        }

        .card {
            background: #020617;
            padding: 2rem 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 480px;
            border: 1px solid #1f2937;
        }

        h1 {
            margin: 0 0 0.75rem;
            font-size: 1.4rem;
            text-align: center;
        }

        p.subtitle {
            margin: 0 0 1.5rem;
            font-size: 0.9rem;
            text-align: center;
            color: #9ca3af;
        }

        .message {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .flag-box {
            padding: 1rem;
            border-radius: 0.5rem;
            background: #022c22;
            border: 1px solid #16a34a;
            margin-top: 1rem;
            font-family: "SF Mono", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.95rem;
            text-align: center;
        }

        .flag-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6ee7b7;
            margin-bottom: 0.4rem;
            display: block;
        }

        .reset-container {
            position: fixed;
            top: 0.75rem;
            right: 0.75rem;
        }

        .reset-btn {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 9999px;
            border: 1px solid #4b5563;
            background: #111827;
            color: #e5e7eb;
            cursor: pointer;
            text-decoration: none;
        }

        .reset-btn:hover {
            background: #1f2937;
        }

        a {
            color: #60a5fa;
        }

        code {
            font-family: "SF Mono", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <a class="reset-btn" href="?reset=1">Clear session &amp; cookies</a>
</div>
<div class="card">
    <h1>CTF – Role Based Access</h1>

    <?php if ($username === null || $role === null): ?>
        <p class="subtitle">Access denied</p>
        <div class="message">
            No valid session cookies were found.<br>
            Please <a href="index.php">login at <code>index.php</code></a> first.
        </div>
    <?php elseif ($role !== 'admin'): ?>
        <!-- Show if cookie role "user" (or other non-admin) tries to access an admin only page -->
        <p class="subtitle">Restricted area</p>
        <div class="message">
            Your current permission level is: <code><?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></code>.<br><br>
            Your permission level is insufficient.
        </div>
    <?php else: ?>
        <p class="subtitle">Welcome, admin <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>
        <div class="flag-box">
            <span class="flag-label">Captured Flag</span>
            <?php echo htmlspecialchars($FLAG2, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
