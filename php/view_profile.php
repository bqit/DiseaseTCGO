<?php
session_start();
require_once("./connection.php");
require_once("./functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $userId = $user_data['user_id'];

    $checkProfileQuery = "SELECT * FROM profile WHERE user_id = ${_GET['id']}";
    $user_profile = mysqli_query($con, $checkProfileQuery)->fetch_row();

    $fetchCreationDate = "SELECT date FROM users WHERE user_id = ${_GET['id']}";
    $guest_data = mysqli_query($con, $fetchCreationDate)->fetch_field();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | <?php echo $user_profile[2]?></title>
    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
    <style><?php include './../stylesheets/profile.css'; ?></style>
    <script><?php include './../js/edit_bio.js'; ?></script>
	<script><?php include './../js/theme_system.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include './../html/header.php'; ?>
    
    <div class="container_view">
        <div class="profile">
            <div class="profile-info">
                <div class="avatar">
                    <i class="fa-solid fa-circle-user"></i>
                </div>
                <div class="username">
                    <span class="username_title"><?php 
                    echo (($user_profile[8] == 1) ? "<i class='fa-solid fa-circle-check'></i> " : ""); echo htmlspecialchars($user_profile[2]);?></span>
                        <button id="container_bio" class="button_description"><span class="user_info"><?php echo htmlspecialchars($user_profile[7]);?> </span><span></span></button>
                    <span class="user_date">Unito il: <?php echo htmlspecialchars($user_profile[10]);?></span>
                </div>
            </div>
            <div class="stats">
                <div class="stat">
                    <p class="stat_title"><i class="fa-solid fa-image-portrait"></i> Carte Collezionate</p>
                    <p>0</p>
                </div>
                <div class="stat">
                    <p class="stat_title"><i class="fa-solid fa-burst"></i> Scontri totali</p>
                    <p>0</p>
                </div>
                <div class="stat">
                    <p class="stat_title"><i class="fa-solid fa-hand-peace"></i> Scontri vinti</p>
                    <p>0</p>
                </div>
            </div>
        </div>
        
        <div class="leaderboard-title">
            <p>Amici in comune</p>
            <p>Amici in comune non ancora disponibili.</p>
        </div>
    </div>

    <span class="welcome">
		<span id="container_theme" class="container_theme_hidden"></span>
        <span id="container_info" class="container_bio_hidden">
            <div class="overlay-dark"><button class="quick_close"></button></div>
            <span class="bio_window">
                <span class="bio_title">Modifica la descrizione.</span>
                    <form method="post">
                        <textarea name="bio" placeholder="Nuova descrizione"><?php echo htmlspecialchars($user_profile['user_bio']);?></textarea>
                        <span class="decisions">
                            <button type="submit" class="ghost" id="signUp" onClick="document.location.href='./login.php'">Conferma</button>
                            <button type="button" class="ghost" id="signUp" onClick="close_window()">Annulla</button>
                        </span>
                    </form>
            </span>
        </span>
	</span>

	<?php include './../html/footer.php'; ?>
</body>
</html>