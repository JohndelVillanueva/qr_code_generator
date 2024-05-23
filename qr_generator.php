<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Validate first and last name
    if (empty($first_name) || empty($last_name)) {
        echo "First name and last name are required.";
        exit;
    }

    // Generate barcode data
    $codeContents = "$first_name $last_name";
    $tempDir = "images/";
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }
    $fileName = '005_file_' . uniqid() . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = $tempDir . $fileName;

    // Generating barcode
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($codeContents, $generator::TYPE_CODE_128);

    file_put_contents($pngAbsoluteFilePath, $barcode);

    // Send email with barcode
    send_email_with_barcode($email, $pngAbsoluteFilePath);
}

function send_email_with_barcode($email, $barcode_path)
{
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: Barcode';
    $body = 'Please keep the barcode attached. <b>CHECK THE SPAM OPTION IF THERE IS NO BARCODE RECEIVED.</b>';

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

        // Recipients
        $mail->setFrom($sender);
        $mail->addAddress($email);

        // Attachments
        $mail->addAttachment($barcode_path);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
