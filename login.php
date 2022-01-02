<?php
    // Ideiglenes session!
    session_start();
    $username_email = $_SESSION["username"];

    function check($value) {
        return trim(htmlspecialchars($value, ENT_QUOTES));
    }

    $loginErrorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Adatbázisba van-e ez a felhasználó és ez-e a jelszava?
    }
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "includes/head.html"; ?>
        <title>Quizion Bejelentkezés</title>
    </head>
    <body>
        <div id="loader_div"><div id="loader"></div></div>
        <?php require_once "includes/header_logo.html"; ?>

        <div class="container">
        <form method="POST">
                <div>
                    <label for="username_email">Felhasználónév vagy email cím</label>
                    <input type="text" id="username_email" name="username_email" value="<?php echo check($username_email); ?>">
                </div>

                <div>
                    <label for="password">Jelszó</label>
                    <input type="password" id="password" name="password" value="">
                </div>

                <input type="submit" value="Bejelentkezés">
                <div class="error_message"><?php echo $loginErrorMessage; ?></div>
            </form>
            <a href="index.php">Vissza</a>
        </div>

        <?php require_once "includes/footer.html"; ?>
        <script src="includes/loader.js"></script>
    </body>
</html>
