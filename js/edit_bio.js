function edit_description() {
    let bio = document.getElementById("container_info");
    if (bio) {
        bio.classList.remove("container_bio_hidden");
        bio.classList.add("container_bio_shown");
    }
}

function close_window(){
    let bio = document.getElementById("container_info");
    if (bio) {
        bio.classList.add("container_bio_hidden");
        bio.classList.remove("container_bio_shown");
    }
}