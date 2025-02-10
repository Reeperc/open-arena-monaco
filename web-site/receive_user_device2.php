<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    file_put_contents('current_user_device2.txt', $user);
}