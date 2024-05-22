<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Generate QR code data
    $codeContents = "$first_name $last_name";
    $tempDir = "images/";
    $fileName = '005_file_' . uniqid($first_name) . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = $tempDir . $fileName;

    // generating
    if (!file_exists($pngAbsoluteFilePath)) {
        $qrCode = QrCode::create($codeContents);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $result->saveToFile($pngAbsoluteFilePath);
        // echo 'File generated!<hr />';
    } else {
        echo 'File already generated! We can use this cached file to speed up site on common codes!<hr />';
    }

    // echo 'Server PNG File: ' . $pngAbsoluteFilePath . '<hr />';
    // echo '<img src="' . $urlRelativeFilePath . '" /><hr />';

    // Send email with QR code
    send_email_with_qr_code($email, $pngAbsoluteFilePath);
}

function send_email_with_qr_code($email, $qr_code_path)
{
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: QR Code';
    $body = 'Please keep the QR code attached.';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@westfields.edu.ph';
        $mail->Password = 'kzeh yyam yhfr xrqh'; // Use environment variables or secure storage for passwords
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        // $mail->SMTPDebug = 2; // Enable debugging if needed

        // Recipients
        $mail->setFrom($sender);
        $mail->addAddress($email);

        // Attachments
        $mail->addAttachment($qr_code_path);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Send QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <form method="post" action="">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name"><br><br>
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name"><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>
        <input type="submit" value="Send QR Code">
    </form>
</body>

</html>