<?php
// index.php
// Intentionally vulnerable login for SQL injection CTF.
// DO NOT USE THIS IN PRODUCTION.

session_start();
require __DIR__ . '/config.php';

// Reset / clear session + cookies
if (isset($_GET['reset'])) {
    // Clear session data
    $_SESSION = [];
    if (session_id() !== '') {
        session_destroy();
    }

    // Clear cookies
    setcookie('username', '', time() - 3600, '/');
    setcookie('role', '', time() - 3600, '/');

    header('Location: index.php');
    exit;
}

$error    = '';
$loggedIn = $_SESSION['logged_in'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw POST values (no escaping on purpose)
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // INTENTIONALLY VULNERABLE QUERY (SQL injection possible)
    // Example payload: ' OR '' = '
    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";

    $result = $mysqli->query($sql);

    if ($result && $result->num_rows === 1) {
        $_SESSION['logged_in'] = true;
        $loggedIn = true;

        // Set insecure cookies for the next challenge.
        // The user will have to tamper with "role" to get admin rights.
        setcookie('username', $username, time() + 3600, '/');
        setcookie('role', 'user', time() + 3600, '/');
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HackIt Login</title>
    <style>
        /* Simple centered login layout */
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
            max-width: 360px;
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

        .field {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
            color: #d1d5db;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.7rem;
            border-radius: 0.375rem;
            border: 1px solid #374151;
            background: #020617;
            color: #e5e7eb;
            font-size: 0.95rem;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            background: #3b82f6;
            color: #f9fafb;
            margin-top: 0.5rem;
        }

        .btn:hover {
            background: #2563eb;
        }

        .error {
            margin-bottom: 1rem;
            padding: 0.6rem 0.7rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid #b91c1c;
            color: #fecaca;
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

        .next-hint {
            margin-top: 1rem;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .next-hint code {
            font-family: "SF Mono", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <a class="reset-btn" href="?reset=1">Clear session & cookies</a>
</div>
<div class="card">
    <?php if (!$loggedIn): ?>
        <h1>HackIt Login</h1>
        <p class="subtitle">Log in to reveal the flag.</p>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="field">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    autocomplete="off"
                    required
                >
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="off"
                    required
                >
            </div>

            <button class="btn" type="submit">Login</button>
        </form>
    <?php else: ?>
        <h1>Flag</h1>
        <p class="subtitle">You are logged in. Here is your flag:</p>

        <div class="flag-box">
            <span class="flag-label">Captured Flag</span>
            <?php echo htmlspecialchars($FLAG, ENT_QUOTES, 'UTF-8'); ?>
        </div>

    <?php endif; ?>
</div>
</body>
</html>
