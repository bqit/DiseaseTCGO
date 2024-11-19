<?php 
session_start();
require_once("./connection.php");
require_once("./functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = $_POST['password'];
    $repeated_password = $_POST['repeated_password'];

    if (!empty($user_name) && !empty($password) && !empty($repeated_password) && !is_numeric($user_name)) {
        if ($password === $repeated_password) {
            if (strlen($password) < 8) {
                echo "La password deve contenere almeno 8 caratteri!";
                die;
            }
            
            $stmt = $con->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                $user_id = random_num(20);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO users (user_id, username, password) VALUES ('$user_id', '$user_name', '$hashed_password')";
    
                if (mysqli_query($con, $query)) {
                    header("Location: ./login.php");
                    
                    $profileQuery = "INSERT INTO profile 
                    (user_id, username, user_image, total_cards, battle_register, battle_won, user_bio, is_verified, is_beta) 
                    VALUES 
                    ('" . mysqli_real_escape_string($con, $user_id) . "', 
                     '" . mysqli_real_escape_string($con, $user_name) . "', 
                     '', 
                     0, 0, 0, 
                     '', 
                     0, 0)";
                        
                    mysqli_query($con, $profileQuery);
    
                    exit;
                } else {
                    $error_message = "<span class='login_error'>Errore durante la registrazione! Riprova più tardi.</span>";
                }
            } else {
                $error_message = "<span class='login_error'>Questo utente esiste già!</span>";
            }
        } else {
            $error_message = "<span class='login_error'>Le password non coincidono!</span>";
        }
    } else {
        $error_message = "<span class='login_error>'I campi devono essere validi.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Registrati</title>
	<link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/login.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
	<script><?php include './../js/theme_system.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container" id="container">
		<div class="form-container sign-in-container">
			<form method="post">
				<h1>Registrati</h1>
				<input id="text" type="text" name="user_name" placeholder="Username" />
				<input id="text" type="password" name="password" placeholder="Password" />
				<input id="text" type="password" name="repeated_password" placeholder="Ripeti password" />
				<a href="#">Problemi a registrarti?</a>
				<button type="submit">Registrati</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
					<h1>Benvenuto!</h1>
					<p>Inserisci le tue credenziali per registrare il tuo profilo.</p>
					<a>Hai già un profilo?</a>
					<button class="ghost" id="signUp" onClick="document.location.href='./login.php'">Accedi</button>
				</div>
			</div>
		</div>
	</div>

	<span id="container_theme" class="container_theme_hidden"></span>
	<?php include './../html/footer.php'; ?>
</body>
</html>