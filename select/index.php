<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require './../db_connection.php';

    $user_info = mysqli_query($db_conn, "SELECT `id`, `username`, `email`, `current_xp`, `level` FROM `user`");

    if (mysqli_num_rows($user_info) > 0) {
        $user_info = mysqli_fetch_all($user_info, MYSQLI_ASSOC);
        echo json_encode(["success" => 1, "user_info" => $user_info]);
    }
    else {
        echo json_encode(["success" => 0]);
    }
?>