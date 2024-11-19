<?php 
function check_login($con) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    header("Location: ./login.php");
    exit;
}

function verifyEmail($user_data, $con): int {
    $stmt = $con->prepare("SELECT email FROM users WHERE email IS NOT NULL AND user_id = ?");
    $stmt->bind_param("i", $user_data['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->fetch_assoc()) {
        return 1;
    }
    return 0;
}

function check_profile($con) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM profile WHERE user_id = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }
}

function random_num($num){
    $text = "";
    if($num < 5)
        $num = 5;
    $len = rand(4, $num);

    for($i = 0; $i < $len; $i++){
        $text .= rand(0, 9);
    }

    return $text;
}

function generate_leaderboard($con){
    $users = get_user_leaderboard($con);
    $emails = get_all_verified_statuses($con);

    for($i = 0; $i < count($users); $i++){
        $username = htmlspecialchars($users[$i]['username']); 
        $date = $users[$i]['date']; 
        $hidden = $users[$i]['hidden'];
        $userid = $users[$i]['user_id'];
        $total_cards = $users[$i]['total_cards'];
        $battle_won = $users[$i]['battle_won'];

        if ($hidden == 1) {
            $username = "Carota[" .($userid % 1000). "]"; 
        }

        if($i === 0){
            $username .= "⠀";
            echo "<div id='first_place' class='table_row'>";
            echo "<div class='column rank'>" . ($i + 1) . "</div>";
            if ($hidden == 0) {
                echo "<div class='column name'><a class='account' id='first_place' href='./view_profile.php?id=" . $userid . "'>" .(($emails[$i]['is_verified'] == '1') ? "<i class='fa-solid fa-circle-check'></i> " : ""). "$username</a><i class='fa-solid fa-crown'></i></div>";
            } else {
                echo "<div class='column name'><a class='account' id='first_place'>" .(($emails[$i]['is_verified'] == '1') ? "<i class='fa-solid fa-circle-check'></i> " : ""). "$username</a><i class='fa-solid fa-crown'></i></div>";
            }
        } else {
            echo "<div class='table_row'>";
            echo "<div class='column rank'>" . ($i + 1) . "</div>";
            if ($hidden == 0) {
                echo "<div class='column name'><a class='account' href='./view_profile.php?id=" . $userid . "'>" .(($emails[$i]['is_verified'] == '1') ? "<i class='fa-solid fa-circle-check'></i> " : ""). "$username</a></div>";
            } else {
                echo "<div class='column name'><a class='account'>" .(($emails[$i]['is_verified'] == '1') ? "<i class='fa-solid fa-circle-check'></i> " : ""). "$username</a></div>";
            }
        }

        echo "<div class='column wpm'>$total_cards</div>
              <div class='column raw'>$battle_won</div>
              <div class='column date'>$date</div>
              </div>";
    }
}

function get_users($con){
    $sql = "SELECT u.user_id, u.username, u.date, p.hidden FROM users AS u JOIN profile AS p ON u.user_id = p.user_id";
    $result = $con->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                "user_id" => $row["user_id"],
                "username" => $row["username"],
                "date" => $row["date"],
                "hidden" => $row["hidden"]
            ];
        }
    }
    return $users;
}

function get_user_leaderboard($con){
    $sql = "SELECT user_id, username, total_cards, battle_won, is_verified, date, hidden FROM profile";
    $result = $con->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                "user_id" => $row["user_id"],
                "username" => $row["username"],
                "total_cards" => $row["total_cards"],
                "battle_won" => $row["battle_won"],
                "is_verified" => $row["is_verified"],
                "date" => $row["date"],
                "hidden" => $row["hidden"],
            ];
        }
    }
    return $users;
}

function get_all_verified_statuses($con) {
    $sql = "SELECT is_verified FROM profile WHERE is_verified IS NOT NULL";
    $result = $con->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                "is_verified" => $row['is_verified'],
            ];
        }
    }
    return $users;
}

function time_left() {
    $end_of_day = strtotime('tomorrow') - 1;
    $current_time = time();
    $time_left = $end_of_day - $current_time;
    echo "<i class='fa-solid fa-clock-rotate-left'></i> $time_left";
}


function hide_email($email){
    $content = substr($email, 0, 3);
    $content .= "****";
    $content .= substr($email, strpos($email, "@"));
    return $content;
}

function is_hidden($con, $user_id) {
    $stmt = $con->prepare("SELECT hidden FROM profile WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['hidden'];
    } else {
        return null;
    }
}