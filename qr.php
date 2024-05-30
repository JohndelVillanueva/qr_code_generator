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

    //Create a JSON File to send to JS Script
    $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name
    );

    $json_data = json_encode($data);

    // Generate QR code data
    $codeContents = "$first_name $last_name";
    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    // Get the Template for the Ticket
    $htmlTemplate = file_get_contents('http://localhost/qr_code_generator/ticket3.php');
    // Replace the Placeholder into the QR Generated
    $htmlTemplate = str_replace('<!--QR-->', $qrCodeDataUri, $htmlTemplate);
    // Displays the Output of the Ticket with the QR Generated
    echo $htmlTemplate;


    $nodePath = 'C:/Program Files/nodejs/node.exe';
    $scriptPath  = 'C:/xampp/htdocs/qr_code_generator/img_generator.js';
    $command = '"'. $nodePath .'" "'. $scriptPath .'"';
    exec($command);

    $postData = file_get_contents('php://input');
    echo $postData;
    if($postData) {

        $filename = isset($_SERVER['HTTP_FILENAME']) ? $_SERVER['HTTP_FILENAME'] : 'screenshot.png';

        file_put_contents($postData, $filename);
        readfile($filename);
        echo 'Image success';
    } else {
        echo 'no data';
    }
    //     $requestData = json_decode($postData, true);

    //     if(isset($requestData['image'])) {
    //         $imageData = base64_decode($requestData['image']);
    //         $filename = isset($requestData['filename']) ? $requestData['filename'] : 'screenshot.png';
    //         file_put_contents($filename, $imageData);

    //         echo 'Image saved successfully';
    //     } else {
    //         echo 'Error data not found';
    //     }
    // } else {
    //     echo 'No data received';
    // }

    // Generate PDF with the QR code
    $imgFilePath = generate_img();

    // Send email with PDF attachment
    send_email_with_img($email, $imgFilePath);
}


function generate_img(){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    
    $screenshotData = file_get_contents('php://input');
    $filename = isset($_SERVER['HTTP_FILENAME']) ? $_SERVER['HTTP_FILENAME'] : ''.$first_name.' '.$last_name.'.png';

    $imgfile= file_put_contents('./images/' .$filename, $screenshotData);

    echo 'Screenshot saved: ' .$filename;

    $nodePath = 'C:/Program Files/nodejs/node.exe';
    $scriptPath  = 'C:/xampp/htdocs/qr_code_generator/img_generator.js';
    $command = '"'. $nodePath .'" "'. $scriptPath .'"';
    exec($command);

    return $imgfile;
}

function send_email_with_img($email, $imgfile) {
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

        //Set the Image
        $mail->addAttachment($imgfile);

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
