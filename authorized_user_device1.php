<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user'])) {
    $user = $_POST['user'];
    file_put_contents('authorized_user_device1.txt', $user);
}
?>