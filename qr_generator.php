<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;

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

    // Read the current count from the file
    $countFile = 'ticket_count.txt';
    if (!file_exists($countFile)) {
        file_put_contents($countFile, 0);
    }
    $count = (int)file_get_contents($countFile);

    // Generate QR code data with ticket number
    $ticketNumber = $count + 1; // Temporarily increment for display
    $codeContents = "Ticket Number: $ticketNumber\nEmail: $email\nName: $first_name $last_name";
    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    // Generate PDF with the QR code
    $pdfFilePath = generate_pdf($qrCodeDataUri, $first_name, $last_name, $ticketNumber);

    // Attempt to send email with PDF attachment
    $emailSent = send_email_with_pdf($email, $pdfFilePath);

    // If email sent successfully, increment the count
    if ($emailSent) {
        file_put_contents($countFile, $count + 1);
    }
}

function generate_pdf($qrCodeDataUri, $first_name, $last_name, $ticketNumber) {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('dpi', 120);
    $dompdf = new Dompdf($options);
    $html = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket</title>
        <!-- Bootstrap CDN  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Javascript CDN  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">
        <link rel="stylesheet" href="reset.css">
        <!-- Custom CSS  -->
        <style>
            * {
                color: darkblue;
            }
    
            .bg-custom {
                background-color: bisque;
            }
    
            .text-detail {
                color: darkblue;
                font-size: 20px;
                font-weight: 600;
            }
    
            /* container layout  */
            .table-container {
                width: 610px;
                height: 300px;
                position: absolute;
                transform: translate(-50%, -50%);
                top: 20%;
                left: 50%;
            }
    
            .wis-image>img {
                width: 320px;
                height: 80px;
            }
    
            .qr-image>img {
                width: 281px;
                height: 286px;
            }
    
            .seat {
                font-size: 16pt;
                font-weight: bold;
                writing-mode: vertical-lr;
                transform: rotate(270deg);
    
            }
        </style>
    </head>
    
    <!-- 492 px for width and 189 px for height  -->
    
    <body>
        <table class="table table-bordered border border-2 border-black" style="width:600px;">
            <tbody>
                <td class="seat" style="width:30px; height:200px; padding:0; margin:0;">Seat No: </td>
                <td style="width:10%; height: 200px; padding:0; margin:0;"><img style="width:200px; height:240px;" src="http://localhost/qr_code_generator/assets/frame.png" alt="no-image"></td>
                <td style="width:30%; height: 200px; padding:0; margin:0;"><img style="width:600px; height: 240px;" src="http://localhost/qr_code_generator/assets/Act 1.png" alt="no image"></td>
            </tbody>
        </table>
    </body>
    
    </html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $output = $dompdf->output();
    $pdfFilePath = 'images/ticket_' . uniqid() . '.pdf';
    file_put_contents($pdfFilePath, $output);

    return $pdfFilePath;
}

function send_email_with_pdf($email, $pdfFilePath) {
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: QR Code';
    $body = 'Please keep the attached PDF containing your QR code. <b>CHECK THE SPAM OPTION IF THERE IS NO EMAIL RECEIVED.</b>';

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

        $mail->addAttachment($pdfFilePath);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo "Email has been sent successfully.";
        header('location: index.php');
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>
