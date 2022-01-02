<?php
    function check($value) {
        return trim(htmlspecialchars($value, ENT_QUOTES));
    }

    $click = $_POST["click"] ?? false;
    $userErrorMessage = "";
    $emailErrorMessage = "";
    $password1ErrorMessage = "";
    $password2ErrorMessage = "";
    $success = 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (empty($_POST["username"])) {
            $username = "";
            $userErrorMessage = "Nincs megadott felhasználónév!";
        }
        else if (mb_strlen(trim($_POST["username"])) < 6) {
            $username = trim(htmlspecialchars($_POST["username"], ENT_QUOTES));
            $userErrorMessage = "A felhasználónévnek minimum 6 karakter hosszúnak kell lennie!";
        }
        // Ez csak egy alap később javítani!
        else if (strtolower(trim($_POST["username"])) === "admin" || strtolower(trim($_POST["username"])) === "quizion") {
            $username = trim(htmlspecialchars($_POST["username"], ENT_QUOTES));
            $userHibaUzenet = "A felhasználónév nem lehet 'admin'!";
        }
        else {
            $username = check($_POST["username"]);
            $success++;
        }

        if (empty($_POST["email"])) {
            $email = "";
            $emailErrorMessage = "Email cím megadása kötelező!";
        }
        // Ez csak egy alap később javítani!
        else if (!str_contains(trim($_POST["email"]), ".") || !str_contains(trim($_POST["email"]), "@")) {
            $email = check($_POST["email"]);
            $emailErrorMessage = "Nem érvényes e-mail cím!";
        }
        else {
            $email = check($_POST["email"]);
            $success++;
        }

        if (empty($_POST["password1"])) {
            $password1 = "";
            $password1ErrorMessage = "A jelszó megadása kötelező!";
        }
        else if (mb_strlen(trim($_POST["password1"])) < 8) {
            $password1 = check($_POST["password1"]);
            $password1ErrorMessage = "A jelszónak minimum 8 karakter hosszúnak kell lennie!";
        }
        /* Nagybetűt számot vagy speciális karaktert kell tartalmaznia! */
        else {
            $password1 = check($_POST["password1"]);
            $success++;
        }

        if ($_POST["password1"] != $_POST["password2"]) {
            $password2 = check($_POST["password2"]);
            $password2ErrorMessage = "Nem egyforma a két jelszó!";
        }
        else {
            $password2 = check($_POST["password2"]);
            $success++;
        }
    }
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "includes/head.html"; ?>
        <title>Quizion Regisztráció</title>
        <script>
            function validateForm() {
                // Validáció!
                return true;
            }
        </script>
    </head>
    <body>
        <div id="loader_div"><div id="loader"></div></div>
        <?php require_once "includes/header_logo.html"; ?>

        <div class="container">
            <form method="POST" onsubmit="return validateForm()">
                <div>
                    <label for="username_id">Felhasználónév</label>
                    <input type="text" id="username_id" name="username" value="<?php echo check($username); ?>">
                    <div class="error_message"><?php echo $userErrorMessage; ?></div>
                </div>

                <div>
                    <label for="email_id">Email cím</label>
                    <input type="email" id="email_id" name="email" value="<?php echo check($email); ?>">
                    <div class="error_message"><?php echo $emailErrorMessage; ?></div>
                </div>

                <div>
                    <label for="password1_id">Jelszó</label>
                    <input type="password" id="password1_id" name="password1" value="<?php echo check($password1); ?>">
                    <div class="error_message"><?php echo $password1ErrorMessage; ?></div>
                </div>

                <div>
                    <label for="password2_id">Jelszó még egyszer</label>
                    <input type="password" id="password2_id" name="password2" value="<?php echo check($password2); ?>">
                    <div class="error_message"><?php echo $password2ErrorMessage; ?></div>
                </div>

                <input type="submit" name="click" value="Regisztráció">
            </form>
            <a href="index.php">Vissza</a>
        </div>

        <?php
            if ($click && $success === 4) {
                //$list = [];
                //array_push($list, $username, $email, $password2);
                //$content = json_encode($list);
                $content =
                "
                {
                    \"name\":\"$username\",
                    \"email\":\"$email\",
                    \"password\":\"$password2\"
                }
                ";

                $curl = curl_init("http://127.0.0.1:8000/api/user/register");

                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

                $json_response = curl_exec($curl);

                $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                curl_close($curl);

                if ($status === 201) {
                    // Ideiglenes session és script!
                    ini_set("session.use_strict_mode", 1);
                    session_set_cookie_params(10);
                    session_start();
                    $_SESSION["username"] = $username;
                    // Jelszó?
                    echo "<script>window.open('login.php', '_self');</script>";
                }
            }
        ?>

        <?php require_once "includes/footer.html"; ?>
        <script src="includes/loader.js"></script>
    </body>
</html>
