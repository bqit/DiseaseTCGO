<?php
session_start();
    require_once("./connection.php");
    require_once("./functions.php");

    $user_data = check_login($con);
	$is_verified = verifyEmail($user_data, $con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Home</title>
	<link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
	<script><?php include './../js/theme_system.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
	<?php $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'default';?>
</head>
<body>
<?php include './../html/header.php'; 
	if (!$is_verified) {
		echo "<header class='verify_email'>
				<span class='advise_content'>
					<span class='message_verify'><i class='fa-solid fa-triangle-exclamation'></i> Devi ancora verificare la tua email!</span>
					<button class='verify_button' onClick=\"document.location.href='./settings.php'\"><i class='fa-solid fa-certificate'></i>  Verificala Subito!</button>
				</span>
			</header>";
	}
?>


	
	
	<span class="welcome">
		<h1>Welcome, <?php echo htmlspecialchars($user_data['username']); ?>!</h1>
		<button class="ghost" id="signUp" onClick="document.location.href='./login.php'">Accedi</button>
		<br>
		<button class="ghost" id="signUp" onClick="document.location.href='./signup.php'">Registrati</button>
		<span id="container_theme" class="container_theme_hidden"></span>
	</span>
    
	<?php include './../html/footer.php'; ?>
</body>
</html>
