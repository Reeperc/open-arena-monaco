<?php
// afficher toutes les erreurs dans le navigateur
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$response = [];

try {
    $mail->isSMTP();
    $mail->Host = '195.221.30.17';
    $mail->SMTPAuth = false;
    $mail->Port = 25;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = '';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->SMTPDebug = 0;

    $mail->setFrom('noreply@arena-monaco.fr', 'Monaco Arena');

    $user1 = isset($_POST['user1']) ? $_POST['user1'] : '';
    $user2 = isset($_POST['user2']) ? $_POST['user2'] : '';

    $mail->addAddress($user1);
    $mail->addAddress($user2);

    $mail->isHTML(true);
    $mail->Subject = 'Allez vous échauffez!';
    $mail->Body    = 'La<b> Monaco Arena </b> est ouverte et la partie va bientot debuter. Vous pouvez vous echauffer avec les autres joueurs';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $response['status'] = 'success';
    $response['message'] = 'Message has been sent';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}

echo json_encode($response);
