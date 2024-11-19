document.addEventListener("DOMContentLoaded", function() {
    let timeLeft = parseInt(document.getElementById("timer").textContent);

    function updateTimer() {
        if (timeLeft > 0) {
            timeLeft--;

            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            document.getElementById("timer").innerHTML = 
            `<i class='fa-solid fa-clock-rotate-left'></i> Nuovi oggetti tra: ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        
        } else {
            timeLeft = 86400; 
        }
    }
    setInterval(updateTimer, 1000);
});