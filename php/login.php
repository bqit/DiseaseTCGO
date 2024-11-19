<?php 
session_start();
require_once("./connection.php");
require_once("./functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: ./index.php");
                exit;
            } else {
                $error_message = "<span class='login_error'>Password errata!</span>";
            }
        } else {
            $error_message = "<span class='login_error'>Nessun utente trovato con questo username!</span>";
        }

        $stmt->close();
    } else {
        $error_message = "<span class='login_error'>Inserisci informazioni valide!</span>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Accedi</title>
	<link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<script><?php include './../js/theme_system.js'; ?></script>
	<style><?php include './../stylesheets/login.css'; ?></style>
	<style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
	<?php $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'default';?>
</head>
<body>
	<div class="container" id="container">
		<div class="form-container sign-in-container">
			<form method="post">
				<h1>Accedi</h1>
				<?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
				<input type="text" name="user_name" placeholder="Username" />
				<input type="password" name="password" placeholder="Password" />
				<a href="#">Password dimenticata?</a>
				<button type="submit">Accedi</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
					<h1>Bentornato!</h1>
					<p>Inserisci le tue credenziali per accedere al tuo profilo.</p>
					<a>Non hai un profilo?</a>
					<button class="ghost" id="signUp" onClick="document.location.href='./signup.php'">Registrati</button>
				</div>
			</div>
		</div>
	</div>
	<span id="container_theme" class="container_theme_hidden"></span>
	<?php include './../html/footer.php'; ?>
</body>
</html>