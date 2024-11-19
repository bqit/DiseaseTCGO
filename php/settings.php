<?php
    session_start();
    require_once("./connection.php");
    require_once("./functions.php");

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];
    $is_verified = verifyEmail($user_data, $con);
    $stmt = $con->prepare("UPDATE profile SET is_verified = ? WHERE user_id = ?");
    $stmt->bind_param("ii", $is_verified, $user_id);
    $stmt->execute();
    $stmt->close();

    if (isset($_POST['hide_profile'])) {
        $stmt = "UPDATE profile SET hidden = CASE hidden WHEN 1 THEN 0 WHEN 0 THEN 1 END WHERE username = '" .mysqli_real_escape_string($con, $user_data['username']). "'";
        mysqli_query($con, $stmt);
    }

    $verifying = isset($_POST['add_email']);
    if ($verifying) {
        $address = mysqli_real_escape_string($con, filter_var($_POST['add_email'], FILTER_VALIDATE_EMAIL));
        $token = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

        if ($address !== false) {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            mail($address, "Disease TCGO - Verifica indirizzo email",
                    "
                    <p>Ciao, <b>" .htmlspecialchars($user_data['username']). "</b>!</p>
                    <p>Grazie per aver verificato la tua email su <b><a href='https://byteportfolio.altervista.org/diseaseTCGO/php/index.php'>Disease Trading Card Game Online</a></b>!<br>
                    Inserisci il codice che segue per completare la verifica del tuo indirizzo email: <b>$otp</b>.</p>
                    <p>Un volta portata a termine l'operazione, otterrai <b>il badge dell'email verificata</b> sul tuo profilo.</p>
                    
                    <p>User token (NON CONDIVIDERE CON NESSUNO IL TUO TOKEN): <b>$token</b></p><br>
                    Se non sei stato tu a inviare questa enail di verifica, ignorala o segnala l'attività al nostro servizio: </p>", $headers);

            $stmt = "INSERT INTO email_tokens VALUES (" .$user_data['user_id']. ", '$token', '$address', '$otp')";
            mysqli_query($con, $stmt);
        }
    }

    $has_code = isset($_POST['otp']);
    if ($has_code) {
        $otp = mysqli_real_escape_string($con, $_POST['otp']);
        
        $stmt = "SELECT COUNT(*) AS count FROM email_tokens WHERE otp = '$otp' AND user_id = " .$user_data['user_id'];
        $result = $con->query($stmt);

        $found = $result->fetch_assoc()['count'] == 1;
        if ($found) {
            $stmt1 = "UPDATE users SET email = (SELECT email FROM email_tokens WHERE otp = '$otp') WHERE user_id = $user_id";
            $stmt2 = "DELETE FROM email_tokens WHERE user_id = $user_id";
            
            mysqli_query($con, $stmt1);
            mysqli_query($con, $stmt2);
            $is_verified = verifyEmail($user_data, $con);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTCGO | Impostazioni</title>
    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
    <style><?php include './../stylesheets/settings.css'; ?></style>
	<script><?php include './../js/theme_system.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>

    <script>
        function open_window() {
            let item = document.getElementById('container_info');
            item.classList.remove("container_email_hidden");
            item.classList.add("container_email_shown");
        }

        function close_window() {
            let item = document.getElementById('container_info');
            item.classList.add("container_email_hidden");
            item.classList.remove("container_email_shown");
        }

        function open_verify() {
            let item = document.getElementById('container_info_verify');
            item.classList.add("container_verify_hidden");
            item.classList.remove("container_verify_shown");
        }
    </script>
</head>
<body>
    <?php include './../html/header.php'; ?>
    <div class="settings_container">
        <span class="settings_header">
            <h1><i class="fa-solid fa-gear"></i> Impostazioni</h1> 
        </span>
        <span class="settings_options_container">
            <span class="settings_row" <?php echo ($is_verified == 1) ? 'id="disabled_row"' : ''; ?>>
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-certificate"></i> Aggiungi verifica email</span>
                    <span class="setting_description">Aggiungi una verifica tramite email al tuo account.<span class="setting_warning"> (Consigliabile)</span></span>
                </span>
                    <span><button type="submit" onclick="open_window()" class="settings_button_ghost"><i class="fa-solid fa-link"></i> <?php echo ($is_verified == 1) ? 'Email verificata' : 'Aggiungi verifica'; ?></button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-user"></i> Aggiorna lo username</span>
                    <span class="setting_description">Cambia il nome del tuo account. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Puoi modificare il tuo username ogni 30 giorni.</span></span>
                </span>
                <span><button type="submit" class="settings_button_ghost"><i class="fa-solid fa-pen-to-square"></i> Modifica username</button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-lock"></i> Modifica password</span>
                    <span class="setting_description">Cambia la password del tuo account. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Puoi modificare la tua password ogni 30 giorni.</span></span>
                </span>
                <span><button type="submit" class="settings_button_ghost"><i class="fa-solid fa-pen-to-square"></i> Modifica password</button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-shield-halved"></i> Nascondi profilo dalla classifica</span>
                    <span class="setting_description">Scegli se mostrare il tuo profilo nella classifica globale.</span>
                </span>

                <form method="post">
                    <input type="hidden" name="hide_profile" value="1">
                    <span><button type="submit" class="settings_button_ghost"><?php echo ((is_hidden($con, $user_id) == 1) ? "<i class='fa-solid fa-eye'></i> Mostra" : "<i class='fa-solid fa-eye-slash'></i>  Nascondi") ?></button></span>
                </form>
            </span>
            <h1><i class="fa-solid fa-triangle-exclamation"></i> DANGER ZONE</h1> 
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-fingerprint"></i> Aggiorna ID utente</span>
                    <span class="setting_description">Aggiorna l'ID utente. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Aggiorna solo se hai il sospetto che qualcuno ne sia entrato <br>in possesso.</span></span>
                </span>
                <span><button type="submit" class="settings_button"><i class="fa-solid fa-wrench"></i> Aggiorna ID</button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-rotate-left"></i> Ripristina le impostazioni</span>
                    <span class="setting_description">Riporta allo stato originario tutte le impostazioni. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Questa azione è irreversibile.</span></span>
                </span>
                <span><button type="submit" class="settings_button"><i class="fa-solid fa-wrench"></i> Ripristina impostazioni</button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-trash"></i> Cancella dati</span>
                    <span class="setting_description">Azzera tutti i dati del tuo account. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Questa azione è irreversibile.</span></span>
                </span>
                <span><button type="submit" class="settings_button"><i class="fa-solid fa-database"></i> Cancella dati</button></span>
            </span>
            <span class="settings_row">
                <span class="settings_col">
                    <span class="setting_title"><i class="fa-solid fa-user-minus"></i> Elimina profilo</span>
                    <span class="setting_description">Cancella il tuo profilo. <span class="setting_warning"><i class="fa-solid fa-triangle-exclamation"></i> Questa azione è irreversibile.</span></span>
                </span>
                <span><button type="submit" class="settings_button"><i class="fa-solid fa-eraser"></i> Elimina profilo</button></span>
            </span>
        </span>
    </div>

    <span class="welcome">
		<span id="container_theme" class="container_theme_hidden"></span>
        <span id="container_info" class="container_email_hidden">
            <div class="overlay-dark"><button class="quick_close"></button></div>
            <span class="verify_email_container">
                <span class="email_title">Inserisci l'email di verifica.</span>
                    <form method="post">
                        <input type="email" placeholder="Indirizzo email" name="add_email">
                        <span class="decisions">
                            <button type="submit" class="ghost" id="sendMail" onClick="open_verify()">Conferma</button>
                            <button type="button" class="ghost" id="sendMail" onClick="close_window()">Annulla</button>
                        </span>
                    </form>
            </span>
        </span>
        <?php if ($verifying) {
            echo '<span id="container_info_verify" class="container_verify_shown">
            <div class="overlay-dark"><button class="quick_close"></button></div>
            <span class="verify_email_container">
            <div id="otp">
                <span class="email_title">Email inviata all&#39;indirizzo '. hide_email($address). '<br>Inserisci il codice di verifica.</span>
                <form method="post">
                    <input type="text" placeholder="Codice di verifica" minlength="4" maxlength="4" name="otp">
                    <span class="decisions">
                        <button type="submit" class="ghost" id="sendMail">Conferma</button>
                        <button type="button" class="ghost" id="sendMail" onClick="resendCode()">Reinvia codice</button>
                    </span>
                </form>
            </div>
            </span>
        </span>';
        }
        ?>
	</span>

<?php include './../html/footer.php'; ?>
</body>
</html>