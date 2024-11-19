<?php
session_start();
require_once("./connection.php");
require_once("./functions.php");

$user_data = check_login($con);
$user_profile = check_profile($con);
$is_verified = verifyEmail($user_data, $con);

$username = ($is_verified) ? "<i class='fa-solid fa-circle-check'></i> " : "";
$username .= htmlspecialchars($user_profile['username']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['bio'])) { 
        $bio = mysqli_real_escape_string($con, $_POST['bio']);
        $userId = $user_data['user_id'];

        $checkProfileQuery = "SELECT * FROM profile WHERE user_id = '$userId'";
        $result = mysqli_query($con, $checkProfileQuery);
        
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE profile SET user_bio = '$bio' WHERE user_id = '$userId'";
            
            if (mysqli_query($con, $sql)) {
                echo "<script>window.location.href = './profile.php';</script>";
            } else {
                echo "Errore durante l'aggiornamento della biografia: " . mysqli_error($con);
            }
        } else {
            $query = "INSERT INTO profile (user_id, username, user_image, total_cards, battle_register, battle_won, user_bio, is_verified, is_beta, date) 
                VALUES ('" . mysqli_real_escape_string($con, $user_data['user_id']) . "', 
                        '" . mysqli_real_escape_string($con, $user_data['username']) . "', 
                        '', 0, 0, 0, '$bio', 0, 0, ". mysqli_real_escape_string($con, $user_data['date']). ")";
            
            if (mysqli_query($con, $query)) {
                echo "<script>window.location.href = './profile.php';</script>";
            } else {
                echo "Errore durante la creazione del profilo: " . mysqli_error($con);
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Profilo</title>
    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
    <style><?php include './../stylesheets/profile.css'; ?></style>
    <script><?php include './../js/edit_bio.js'; ?></script>
	<script><?php include './../js/theme_system.js'; ?></script>
    <script><?php include './../js/logout.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include './../html/header.php'; ?>
    
    <span class="info_container">
        <div class="settings_row">
            <span class="control_panel_title"><i class="fa-solid fa-gear"></i> Pannello di controllo</span>
            <input type="checkbox" id="buttons-toggle">
            <label for="buttons-toggle" class="menu-icon">&#9776;</label>
            <ul class="buttons_menu">
                    <li><button type="submit" class="ghostInfo" id="signUp" onClick="document.location.href='./settings.php'"><i class="fa-brands fa-discord"></i> Unisciti su Discord</button></li>
                    <li><button type="submit" class="ghostInfo" id="signUp" onClick="document.location.href='./settings.php'"><i class="fa-solid fa-ticket"></i> Riscatta Codice</button></li>
                    <li><button type="submit" class="ghostInfo" id="signUp" onClick="document.location.href='./settings.php'"><i class="fa-solid fa-file-invoice-dollar"></i> Storico Pagamenti</button></li>
                    <li><button type="submit" class="ghostInfo" id="signUp" onClick="document.location.href='./settings.php'"><i class="fa-solid fa-gears"></i> Impostazioni</button></li>
                    <li><button type="submit" class="ghostInfo" id="signUp" onClick="logout()"><i class="fa-solid fa-right-from-bracket"></i> Esci</button></li>
            </ul>     
        </div>
        <div class="container">
            <div class="profile">
                <div class="profile-info">
                    <div class="avatar">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="username">
                        <span class="username_title"><?php echo $username;?></span>
                            <button id="container_bio" class="button_description" onclick="edit_description(this)"><span class="user_info"><?php echo htmlspecialchars($user_profile['user_bio']);?> </span><span><i class="fa-solid fa-pen-to-square"></i></span></button>
                        <span class="user_date">Unito il: <?php echo htmlspecialchars($user_data['date']);?></span>
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
    </span>

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