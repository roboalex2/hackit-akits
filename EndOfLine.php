<?php
// EndOfLine.php
// Final page of the CTF chain

session_start();

// Reset / clear session + cookies
if (isset($_GET['reset'])) {
    $_SESSION = [];
    if (session_id() !== '') {
        session_destroy();
    }

    setcookie('username', '', time() - 3600, '/');
    setcookie('role', '', time() - 3600, '/');

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CTF Complete</title>
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
            background: #020617;
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
            text-align: center;
        }

        h1 {
            margin: 0 0 1rem;
            font-size: 1.8rem;
        }

        p {
            font-size: 1rem;
            color: #9ca3af;
        }

        .done {
            margin-top: 1.5rem;
            font-size: 1.2rem;
            color: #22c55e;
            font-weight: 600;
        }

        .links {
            margin-top: 1.5rem;
        }

        .link-btn {
            display: inline-block;
            margin: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            border: 1px solid #4b5563;
            background: #111827;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .link-btn:hover {
            background: #1f2937;
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
    </style>
</head>
<body>

<div class="reset-container">
    <a class="reset-btn" href="?reset=1">Clear session &amp; cookies</a>
</div>

<div class="card">
    <h1>End of Line</h1>
    <p>You made it through all challenges.</p>

    <div class="done">
        You did it.
    </div>

    <p style="margin-top:1.25rem;">
        There are no more hack-its.
    </p>

    <div class="links">
        <a class="link-btn" href="README.html">View README / Solutions</a>
        <a class="link-btn" href="?reset=1">Restart Challenge</a>
    </div>
</div>

</body>
</html>
