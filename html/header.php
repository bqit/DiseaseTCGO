<header class="header">
    <nav>
        <div class="logo">
        <a href="./index.php"><span class="logo_style"><img class="logo" src="./../imgs/dtcgo_logo.png"><span class="text_style"><span>Disease⠀⠀⠀⠀⠀⠀</span><span class="text_subtitle">Trading Card Game Online</span></span></span></a>
        </div>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <ul class="menu">
        <li><a href="./community.php"><i class="fa-solid fa-earth-europe"></i> Community</a></li>
        <li><a href="./leaderboard.php"><i class="fa-solid fa-trophy"></i> Classifica</a></li>
        <li><a href="./collection.php"><i class="fa-solid fa-book-skull"></i> Collezione</a></li>
        <li><a href="./shop.php"><i class="fa-solid fa-store"></i> Negozio</a></li>
        <li><a href="./profile.php"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($user_data['username']);?><span class="notifies">Novità!</span></a></li>
        </ul>
    </nav>
</header>