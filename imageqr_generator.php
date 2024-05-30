<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }
    if (empty($first_name) || empty($last_name)) {
        echo "First name and last name are required.";
        exit;
    }

    //Not Working Properly/ Not Executing
    $command = 'node http://localhost/qr_code_generator/img_generator.js';
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        echo "Error executing script";
        exit;
    }

    send_email_with_image($email);
}

function send_email_with_image($email){
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: QR Code';
    $body = 'Please keep the attached image containing your QR Code!';

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@westfields.edu.ph';
        $mail->Password = 'kzeh yyam yhfr xrqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($sender);
        $mail->addAddress($email);

        //Attach generated Image
        $mail->addAttachment('images/user1716882374285_9345.png');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo "Email has been sent successfully.";
        header('location: index.php');
    } catch (Exception $e){
        echo "Message could not be sent. Error;";
    }
    }