<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DTCGO | Utente non trovato!</title>

    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>

	<style><?php include './../stylesheets/index.css'; ?></style>

    <style><?php include './../stylesheets/color_palettes.css'; ?></style>

	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>

	<script><?php include './../js/theme_system.js'; ?></script>

    <style><?php include './../stylesheets/connection_failed.css'; ?></style>

	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>

	<?php $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'default';?>

</head>

<body>

    

    <span class="box">

        <img class="logo" src="./../imgs/dtcgo_logo.png">

		<h1 class="title_err">UTENTE NON TROVATO!</h1>

		<span id="container_theme" class="container_theme_hidden"></span>

        <p class="err_message">Impossibile trovare l'utente. L'ID utente potrebbe non essere esatto oppure è stato cancellato.</p>

        <p class="err_code">Codice errore (2): user_id unavailable or unreachable</p>

        <a class="report" href="mailto:dtcgo.reports@gmail.com">Segnala incongruenza</a>

	</span>

</body>

</html>
