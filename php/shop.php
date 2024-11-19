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
    <title>DTCGO | Negozio</title>
    <link rel="icon" href="./../imgs/dtcgo_icon.ico"/>
	<style><?php include './../stylesheets/index.css'; ?></style>
    <style><?php include './../stylesheets/color_palettes.css'; ?></style>
	<style><?php include './../stylesheets/color_themes_previews.css'; ?></style>
    <style><?php include './../stylesheets/shop.css'; ?></style>
	<script><?php include './../js/theme_system.js'; ?></script>
    <script><?php include './../js/shop_timer.js'; ?></script>
	<script src="https://kit.fontawesome.com/7028f82e51.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include './../html/header.php'; ?>

    <div class="shop_container">
    <span class="shop_header">
        <h1><i class="fa-solid fa-cart-shopping"></i> Negozio</h1> 
        <div class="center_controls">
            <button id="container_bio" class="button_description" onclick="edit_description(this)">
                <span class="shop_resources"><i class="fa-solid fa-circle-info">⠀⠀</i> <i class="fa-solid fa-carrot"></i>⠀0</span>
            </button>
            <span class="shop_time">
                <span id="timer"><?php time_left();?></span>
            </span>
        </div>
        </span>
        <span class="shop_items_container">
            <button id="container_bio" class="important_item"><span><h2><i class="fa-solid fa-heart"></i> IN PRIMO PIANO</h2></span></button>
            <button id="container_bio" class="important_item"><span><h2><i class="fa-solid fa-heart"></i> IN PRIMO PIANO</h2></span></button>
            <span class="minor_items_container">
                <button id="container_bio" class="minor_items_a"><span><h2><i class="fa-solid fa-eye"></i> PICCOLO SGUARDO</h2></span></button>
                <button id="container_bio" class="minor_items_b"><span><h2><i class="fa-solid fa-piggy-bank"></i> OFFERTA</h2></span></button>
            </span>
        </span>
    </div>


    <span class="welcome">
		<span id="container_theme" class="container_theme_hidden"></span>
	</span>

	<?php include './../html/footer.php'; ?>
</body>
</html>