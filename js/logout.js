function logout(){
    document.cookie = "PHPSESSID=; Path=/";
    location.href = "./login.php";
}