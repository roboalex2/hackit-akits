<?php

$pw_level3 = "myheaderpass";

$page = $_GET["page"] ?? "level3";

switch ($page) {
    case "check3": check3(); break;
    default: level3(); break;
}

function html_header($title = "HackIt – Level 3") {
    echo "
    <!DOCTYPE html>
    <html lang='de'>
    <head>
        <meta charset='UTF-8'>
        <title>$title</title>
        <style>

            body {
                background: #111;
                color: #f0f0f0;
                font-family: Arial, sans-serif;
                text-align: center;
                padding-top: 40px;
            }

            .box {
                background: #1e1e1e;
                padding: 25px;
                width: 380px;
                margin: auto;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.4);
            }

            h1 {
                font-size: 26px;
                color: #4af;
                margin-bottom: 10px;
            }

            p {
                color: #ccc;
            }

            input[type=text] {
                padding: 10px;
                width: 90%;
                border-radius: 6px;
                border: none;
                margin-top: 10px;
                font-size: 16px;
            }

            button {
                margin-top: 15px;
                padding: 12px 20px;
                background: #4af;
                color: #000;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
                font-weight: bold;
            }

            button:hover {
                background: #75c6ff;
            }

            a {
                color: #4af;
            }

        </style>
    </head>
    <body>
    ";
}

function level3() {
    global $pw_level3;

    header("X-Secret-PW: $pw_level3");

    html_header("HTTP Header");

    echo "
    <div class='box'>
    <!-- Was ist noch einmal alles in einem HTTP Header enthalten? -->
        <p>...</p>

        <form action='index.php?page=check3' method='POST'>
            <input type='text' name='pw' placeholder='Passwort eingeben'>
            <button type='submit'>Check</button>
        </form>
    </div>
    </body></html>";
}


// ------------------------------------------
// CHECK Passwort
// ------------------------------------------
function check3() {
    global $pw_level3;

    html_header("Level 3 – Ergebnis");

    $input = $_POST["pw"] ?? "";

    echo "<div class='box'>";

    if ($input === $pw_level3) {
        echo "<h1>✔️ Richtig!</h1><p>FLAG{loginSql.php}</p>";
    } else {
        echo "<h1>❌ Falsch!</h1>
              <p>Versuche es nochmal.</p>
              <a href='index.php'>Zurück zur Aufgabe</a>";
    }

    echo "</div></body></html>";
}
?>
