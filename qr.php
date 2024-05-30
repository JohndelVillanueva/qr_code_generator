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
    if (empty($first_name) || empty($last_name)) {
        echo "First name and last name are required.";
        exit;
    }

    // Generate QR code data
    $codeContents = "$first_name $last_name";
    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    $htmlTemplate = file_get_contents('http://localhost/qr_code_generator/ticket3.php');
    $htmlTemplate = str_replace('<!--QR-->', $qrCodeDataUri, $htmlTemplate);

    echo $htmlTemplate;

    // Generate PDF with the QR code
    $imgFilePath = generate_img($first_name, $last_name, $email);

    // Send email with PDF attachment
    send_email_with_img($email, $imgFilePath);
}


function generate_img($first_name,$last_name, $email){
    
    // $email = $_POST['email'];
    // $first_name = $_POST['first_name'];
    // $last_name = $_POST['last_name'];
    
    $nodePath = 'C:/Program Files/nodejs/node.exe';
    $scriptPath  = 'C:/xampp/htdocs/qr_code_generator/img_generator.js';
    $command = '"'. $nodePath .'" "'. $scriptPath .'" "'.$first_name.'" "'.$last_name.'" "'.$email.'"';
    $output = exec($command);

    if ($output === 'success'){
        $imgFilePath = './images/'.$first_name.$last_name.'.png';
        return $imgFilePath;
    } else{
        echo "Failed";
        return false;
    }

}

function send_email_with_img($email, $imgFilePath) {
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: QR Code ';
    $body = 'Please keep the attached PDF containing your QR code. <b> CHECK THE SPAM OPTION IF THERE IS NO EMAIL RECEIVED.</b>';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@westfields.edu.ph';
        $mail->Password = 'kzeh yyam yhfr xrqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($sender);
        $mail->addAddress($email);

        $mail->addAttachment($imgFilePath);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo "Email has been sent successfully.";
        // header('location: index.php' );
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
