document.addEventListener("DOMContentLoaded", function(){
    loadThemeContainer();
    if (getCookie("theme") == null) {
        set_theme("default");
    }
});

function preview(theme) {
    document.documentElement.className = theme;
}

function show_themes() {
    let item = document.getElementById("container_theme");
    if (item) {
        item.classList.add("container_theme_shown");
        item.classList.remove("container_theme_hidden")
    }
}

function set_theme(theme) {
    let button = document.getElementById("button");

    let target = document.getElementById("container_theme");
    target.classList.add("container_theme_hidden");
    target.classList.remove("container_theme_shown")
    button.innerHTML = update_string(theme);

    document.documentElement.className = theme;
    document.cookie = "theme=" + theme + "; path=/; max-age=" + (60*60*24*30);
}

window.onload = function() {
    const theme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if (theme) document.documentElement.className = theme;
    
    let button = document.getElementById("button");
    button.innerHTML = update_string(theme);
};

function quick_close(){
    let target = document.getElementById("container_theme");
    target.classList.add("container_theme_hidden");
    target.classList.remove("container_theme_shown")

    const theme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if (theme) document.documentElement.className = theme;
}

function update_string(theme){
    let string_title = "internal_error"
    switch(theme) {
        case 'default':
            string_title = "DTCGO Default";
        break;
        case 'light':
            string_title = "DTCGO Light";
        break;
        case 'retro':
            string_title = "Retrò";
        break;
        case 'hellokitty':
            string_title = "Hello Kitty";
        break;
        case 'peach':
            string_title = "Pesca";
        break;
        case 'tiramisu':
            string_title = "Tiramisù";
        break;
        case 'cyberred':
            string_title = "Cyber Red";
        break;
        case 'lavender':
            string_title = "Lavanda";
        break;
        case 'matrix':
            string_title = "Matrix";
        break;
        case 'stealth':
            string_title = "Stealth";
        break;
        case 'chiesenewyear':
            string_title = "Capodanno Cinese";
        break;
        case 'evangelion':
            string_title = "Evangelion";
        break;
        case 'pro':
            string_title = "DTCGO Pro";
        break;
        case 'mint':
            string_title = "Menta";
        break;
        case 'latte':
            string_title = "Latte";
        break;
        case 'inferno':
            string_title = "Inferno";
        break;
        case 'snes':
            string_title = "SNES";
        break;
        case 'vivid':
            string_title = "Vivido";
        break;
        case 'cyberred':
            string_title = "Cyber Red";
        break;
        case 'watermelon':
            string_title = "Cocomero";
        break;
        case 'igor':
            string_title = "IGOR";
        break;
        case 'tacos':
            string_title = "Tacos";
        break;
        case 'matchamocha':
            string_title = "Matcha Mocha";
        break;
        case 'deepocean':
            string_title = "Deep Ocean";
        break;
        case 'igor':
            string_title = "IGOR";
        break;
        case 'honey':
            string_title = "Honey";
        break;
        case 'incognito':
            string_title = "Incognito";
        break;
        case 'doomsday':
            string_title = "Doomsday";
        break;
        case 'discord':
            string_title = "Discord";
        break;
        case 'cherry':
            string_title = "Ciliegia";
        break;
    }

    return "<i class='fa-solid fa-palette'></i>" + " " + string_title;
}

function loadThemeContainer() {
    fetch('./../html/themes.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('container_theme').innerHTML = data;
        })
        .catch(error => console.error('Error loading theme container:', error));
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
}