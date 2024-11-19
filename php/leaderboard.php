<?php
session_start();
    require_once("./connection.php");
    require_once("./functions.php");

    $user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Classifica</title>
    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
    <style><?php include './../stylesheets/leaderboard.css'; ?></style>
	<script><?php include './../js/theme_system.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
</head>
<body>
	<?php include './../html/header.php'; ?>
	    
	<div class="leaderboard">
        <h1><i class="fa-solid fa-trophy"></i> Classifica</h1>
        <div class="table_header">
            <div class="column rank"><i class="fa-solid fa-ranking-star"></i></div>
            <div class="column name"><i class="fa-solid fa-user"></i>⠀Username</div>
            <div class="column wpm"><i class="fa-solid fa-image-portrait"></i> Carte collezionate</div>
            <div class="column raw"><i class="fa-solid fa-burst"></i> Scontri vinti</div>
            <div class="column date"><i class="fa-solid fa-clock"></i> Creazione profilo</div>
        </div>
        <span class="user_container">
            <?php generate_leaderboard($con) ?>
        </span>
    </div>

	<span class="welcome">
		<span id="container_theme" class="container_theme_hidden"></span>
	</span>

	<?php include './../html/footer.php'; ?>
</body>
</html>